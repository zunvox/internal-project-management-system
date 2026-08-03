<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->orderBy('name')
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function updateStatus(
        Request $request,
        User $user
    ): RedirectResponse {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in(['Active', 'Inactive']),
            ],
        ]);

        // Prevent an admin from deactivating their own account accidentally.
        if ($request->user()->is($user)) {
            return back()->withErrors([
                'status' => 'You cannot deactivate your own account.',
            ]);
        }

        $user->update([
            'status' => $validated['status'],
        ]);

        return back()->with(
            'success',
            "{$user->name}'s account is now {$validated['status']}."
        );
    }
}