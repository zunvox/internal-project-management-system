<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    /**
     * Display the User Management list.
     */
    public function index(Request $request): View
    {
        $query = User::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($userQuery) use ($search) {
                $userQuery
                    ->where('username', 'like', "%{$search}%")
                    ->orWhere('fullname', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Role filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        /*
        |--------------------------------------------------------------------------
        | Status filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $allCount = User::count();
        $developerCount = User::where('role', 'Developer')->count();
        $adminCount = User::where('role', 'Admin')->count();
        $activeCount = User::where('status', 'Active')->count();
        $inactiveCount = User::where('status', 'Inactive')->count();

        return view(
            'admin.admin-user.users-index',
            compact(
                'users',
                'allCount',
                'developerCount',
                'adminCount',
                'activeCount',
                'inactiveCount'
            )
        );
    }


    /**
     * Display the Add User page.
     */
    public function create(): View
    {
        $nextAdminId =
            $this->generateNextUserId('Admin');

        $nextDeveloperId =
            $this->generateNextUserId('Developer');

        return view(
            'admin.admin-user.create-user',
            compact(
                'nextAdminId',
                'nextDeveloperId'
            )
        );
    }


    /**
     * Store a newly created user.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'fullname' => [
                'required',
                'string',
                'max:130',
            ],

            'username' => [
                'nullable',
                'string',
                'max:150',
                'unique:users,username',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'address' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'role' => [
                'required',
                Rule::in([
                    'Admin',
                    'Developer',
                ]),
            ],

            'status' => [
                'required',
                Rule::in([
                    'Active',
                    'Inactive',
                ]),
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'profile_picture' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Auto-generate User ID
        |--------------------------------------------------------------------------
        */

        $validated['userid'] =
            $this->generateNextUserId(
                $validated['role']
            );


        /*
        |--------------------------------------------------------------------------
        | Password
        |--------------------------------------------------------------------------
        */

        $validated['password'] =
            Hash::make(
                $validated['password']
            );


        /*
        |--------------------------------------------------------------------------
        | Profile Picture
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] =
                $request
                    ->file('profile_picture')
                    ->store(
                        'profile-pictures',
                        'public'
                    );
        }


        /*
        |--------------------------------------------------------------------------
        | Create User
        |--------------------------------------------------------------------------
        */

        User::create($validated);


        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'User account created successfully.'
            );
    }


    /**
     * Display one user's details.
     */
    public function show(User $user): View
    {
        return view(
            'admin.admin-user.view-user',
            compact('user')
        );
    }


    /**
     * Display the Edit User page.
     */
    public function edit(User $user): View
    {
        return view(
            'admin.admin-user.edit-user',
            compact('user')
        );
    }


    /**
     * Update an existing user.
     */
    public function update(
        Request $request,
        User $user
    ): RedirectResponse
    {
        $validated = $request->validate([
            'userid' => [
                'required',
                'string',
                'max:30',
            ],

            'fullname' => [
                'required',
                'string',
                'max:130',
            ],

            'username' => [
                'nullable',
                'string',
                'max:150',
            ],

            'email' => [
                'required',
                'email',
                'max:255',

                Rule::unique(
                    'users',
                    'email'
                )->ignore($user->id),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'address' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'role' => [
                'required',
                Rule::in([
                    'Admin',
                    'Developer',
                ]),
            ],

            'status' => [
                'required',
                Rule::in([
                    'Active',
                    'Inactive',
                ]),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            'profile_picture' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Protect currently logged-in Admin
        |--------------------------------------------------------------------------
        */

        if ($request->user()->is($user)) {
            if ($validated['status'] === 'Inactive') {
                return back()
                    ->withErrors([
                        'status' =>
                            'You cannot deactivate your own account.',
                    ])
                    ->withInput();
            }

            if ($validated['role'] !== 'Admin') {
                return back()
                    ->withErrors([
                        'role' =>
                            'You cannot remove your own Admin role.',
                    ])
                    ->withInput();
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Keep existing password if empty
        |--------------------------------------------------------------------------
        */

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] =
                Hash::make(
                    $validated['password']
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Replace profile picture
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('profile_picture')) {
            if (
                $user->profile_picture &&
                Storage::disk('public')
                    ->exists($user->profile_picture)
            ) {
                Storage::disk('public')
                    ->delete($user->profile_picture);
            }

            $validated['profile_picture'] =
                $request
                    ->file('profile_picture')
                    ->store(
                        'profile-pictures',
                        'public'
                    );
        }


        $user->update($validated);


        return redirect()
            ->route(
                'admin.users.show',
                $user
            )
            ->with(
                'success',
                'User information updated successfully.'
            );
    }


    /**
     * Generate the next Admin/Developer ID.
     */
    private function generateNextUserId(
        string $role
    ): string {
        $prefix =
            $role === 'Admin'
                ? 'ADM'
                : 'DEV';

        $lastUser =
            User::where(
                'userid',
                'like',
                $prefix . '-%'
            )
                ->orderByRaw(
                    "CAST(SUBSTRING(userid, 5) AS UNSIGNED) DESC"
                )
                ->first();

        $nextNumber =
            $lastUser
                ? ((int) substr(
                    $lastUser->userid,
                    4
                )) + 1
                : 1;

        return $prefix . '-' . str_pad(
            $nextNumber,
            4,
            '0',
            STR_PAD_LEFT
        );
    }
}