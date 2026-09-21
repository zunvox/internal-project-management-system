<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectMilestone;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DeveloperProjectController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $projects = Project::with([
            'creator',
            'assignedUsers',
            'milestones.user',
        ])
            ->whereHas('assignedUsers', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })
            ->latest()
            ->get();

        $ongoingProjects = $projects->where('status', 'Ongoing');
        $completedProjects = $projects->where('status', 'Completed');
        $onHoldProjects = $projects->where('status', 'On Hold');

        $projectData = $projects->mapWithKeys(function ($project) {
            return [
                $project->id => [
                    'id' => $project->id,
                    'name' => $project->name,
                    'status' => $project->status,
                    'description' => $project->description ?? 'No project description.',
                    'creator' => $project->creator?->fullname ?? 'Unknown Admin',
                    'start_date' => $project->start_date?->format('d F Y'),
                    'end_date' => $project->end_date?->format('d F Y'),
                    'developers' => $project->assignedUsers
                        ->map(function ($developer) {
                            return [
                                'name' => $developer->fullname,
                                'photo' => $developer->profile_picture
                                    ? asset('storage/' . $developer->profile_picture)
                                    : null,
                            ];
                        })
                        ->values()
                        ->all(),

                    'milestones' => $project->milestones
                        ->map(function ($milestone) {
                            return [
                                'id' => $milestone->id,
                                'description' => $milestone->description,
                                'user_id' => $milestone->user_id,
                                'user' => $milestone->user?->fullname ?? 'Unknown Developer',
                                'user_photo' => $milestone->user?->profile_picture ? asset('storage/' . $milestone->user->profile_picture) : null,
                                'created_at' => $milestone->created_at->format('d F Y, h:i A'),
                            ];
                        })
                        ->values()
                        ->all(),
                ],
            ];
        });

        return view('developer.projects.index', compact(
            'projects',
            'ongoingProjects',
            'completedProjects',
            'onHoldProjects',
            'projectData'
        ));
    }

    public function storeMilestone(
        Request $request,
        Project $project
    ) {
        $user = auth()->user();

        $isAssigned = $project->assignedUsers()
            ->where('users.id', $user->id)
            ->exists();

        abort_unless($isAssigned, 403);

        $validated = $request->validate([
            'description' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);

        $milestone = ProjectMilestone::create([
            'project_id' => $project->id,
            'user_id' => $user->id,
            'description' => $validated['description'],
        ]);

        $milestone->load('user');

        return response()->json([
            'success' => true,

            'milestone' => [
                'id' => $milestone->id,
                'user_id' => $milestone->user_id,
                'description' => $milestone->description,
                'user' => $milestone->user?->fullname ?? 'Unknown Developer',
                'user_photo' => $milestone->user?->profile_picture ? asset('storage/' . $milestone->user->profile_picture) : null,
                'created_at' => $milestone->created_at->format('d F Y, h:i A'),
            ],
        ]);
    }

    public function destroyMilestone(
        Project $project,
        ProjectMilestone $milestone
    ) {
        $user = auth()->user();

        $isAssigned = $project->assignedUsers()
            ->where('users.id', $user->id)
            ->exists();

        abort_unless($isAssigned, 403);

        abort_unless(
            $milestone->project_id === $project->id,
            404
        );

        abort_unless(
            $milestone->user_id === $user->id,
            403
        );

        $milestone->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}
