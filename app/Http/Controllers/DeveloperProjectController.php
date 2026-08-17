<?php

namespace App\Http\Controllers;

use App\Models\Project;
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
        ])
        ->whereHas('assignedUsers', function($query) use ($user)
        {
            $query->where('users.id', $user->id);
        })
        ->latest()
        ->get();

        $notStartedProjects = $projects->where('status', 'Not Started');
        $ongoingProjects = $projects->where('status', 'Ongoing');
        $completedProjects = $projects->where('status', 'Completed');

        return view('developer.projects.index', compact(
            'projects',
            'notStartedProjects',
            'ongoingProjects',
            'completedProjects'
        ));
    }
}
