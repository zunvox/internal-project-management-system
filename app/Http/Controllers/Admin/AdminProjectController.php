<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectMilestone;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class AdminProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::with([
            'creator',
            'assignedUsers',
        ])
            ->latest()
            ->get();

        $notStartedProjects = $projects->where('status', 'Not Started');
        $ongoingProjects = $projects->where('status', 'Ongoing');
        $completedProjects = $projects->where('status', 'Completed');
        $onHoldProjects = $projects->where('status', 'On Hold');
        $cancelledProjects = $projects->where('status', 'Cancelled');

        return view('admin.projects.index', compact(
            'projects',
            'notStartedProjects',
            'ongoingProjects',
            'completedProjects',
            'onHoldProjects',
            'cancelledProjects'
        ));
    }

    public function create(): View
    {
        $developers = User::where('role', 'Developer')
            ->where('status', 'Active')
            ->orderBy('fullname')
            ->get();

        return view('admin.projects.create', compact('developers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],

            'developers' => ['required', 'array', 'min:1'],
            'developers.*' => ['integer',
                Rule::exists('users', 'id')
                    ->where('role', 'Developer')
                    ->where('status', 'Active'),
            ],
        ]);

        $project = Project::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => 'Not Started',
            'created_by' => auth()->id(),
        ]);

        $project->assignedUsers()->attach($validated['developers']);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    public function edit(Project $project): View
    {
        $project->load([
            'creator',
            'assignedUsers',
            'milestones.user',
        ]);

        $developers = User::where('role', 'Developer')
            ->where('status', 'Active')
            ->orderBy('fullname')
            ->get();

        return view('admin.projects.edit', compact(
            'project',
            'developers'
        ));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'description' => ['nullable', 'string'],

            'start_date' => ['required', 'date'],

            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
            ],

            'status' => [
                'required',
                Rule::in([
                    'Not Started',
                    'Ongoing',
                    'On Hold',
                    'Cancelled',
                    'Completed',
                ]),
            ],

            'developers' => [
                'required',
                'array',
                'min:1',
            ],

            'developers.*' => [
                'integer',
                Rule::exists('users', 'id')
                    ->where('role', 'Developer')
                    ->where('status', 'Active'),
            ],
        ]);

        $project->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => $validated['status'],
        ]);

        $project->assignedUsers()->sync(
            $validated['developers']
        );

        $project->touch();

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    public function storeMilestone(
        Request $request,
        Project $project
    ) {
        $user = auth()->user();

        $validated = $request->validate([
            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'attachment' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx,zip',
                'max:10240',
            ],
        ]);

        if (
            empty($validated['description']) &&
            !$request->hasFile('attachment')
        ) {
            return response()->json([
                'message' => 'Please enter a milestone update or attach a file.',
            ], 422);
        }

        $attachmentPath = null;
        $attachmentName = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');

            $attachmentName =
                $file->getClientOriginalName();

            $attachmentPath =
                $file->store(
                    'milestone-attachments',
                    'public'
                );
        }

        $milestone = ProjectMilestone::create([
            'project_id' => $project->id,
            'user_id' => $user->id,

            'description' =>
                $validated['description'] ?? null,

            'attachment_path' =>
                $attachmentPath,

            'attachment_name' =>
                $attachmentName,
        ]);

        $milestone->load('user');

        return response()->json([
            'success' => true,

            'milestone' => [
                'id' => $milestone->id,

                'user_id' =>
                    $milestone->user_id,

                'description' =>
                    $milestone->description,

                'attachment_name' =>
                    $milestone->attachment_name,

                'attachment_url' =>
                    $milestone->attachment_path
                        ? asset(
                            'storage/' .
                            $milestone->attachment_path
                        )
                        : null,

                'user' =>
                    $milestone->user?->fullname
                    ?? 'Unknown User',

                'created_at' =>
                    $milestone->created_at
                        ->format('h:i A'),
            ],
        ]);
    }

    public function destroyMilestone(
        Project $project,
        ProjectMilestone $milestone
    ) {
        abort_unless(
            $milestone->project_id == $project->id,
            404
        );

        if (
            $milestone->attachment_path &&
            Storage::disk('public')
                ->exists(
                    $milestone->attachment_path
                )
        ) {
            Storage::disk('public')
                ->delete(
                    $milestone->attachment_path
                );
        }

        $milestone->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
