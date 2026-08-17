<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

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

        return view('admin.projects.index', compact(
            'projects',
            'notStartedProjects',
            'ongoingProjects',
            'completedProjects'
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

            'status' =>[
                'required',
                Rule::in([
                    'Not Started',
                    'Ongoing',
                    'Blockage',
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

        return redirect()
        ->route('admin.projects.index')
        ->with('success', 'Project updated successfully,');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()
        ->route('admin.projects.index')
        ->with('success', 'Project deleted successfully');
    }



}
