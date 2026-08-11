<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    /*Display the User Management list.*/
    
    public function index(Request $request): View
    {
        $query = User::query();

        /* Search (by name,email,phone*/

        if ($request->filled('search')) 
            {
                $search = $request->search;

                $query->where(function ($userQuery) use ($search) 
                {
                    $userQuery
                        ->where('username', 'like', "%{$search}%")
                        ->orWhere('fullname','like',"%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            }

        /*Role filter*/

        if ($request->filled('role')) 
            {
                $query->where('role', $request->role);
            }

        /*Status filter*/

        if ($request->filled('status')) 
            {
                $query->where('status', $request->status);
            }

        $users = $query
            ->orderBy('fullname')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users-index', compact('users'));
    }

    /* Display the Add User page.*/

    public function create(): View
    {
        return view('admin.create-user');
    }

    /* Store a newly created user.*/

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'userid' => ['required', 'string', 'max:30',],
            
            'fullname' => ['required', 'string', 'max:130',],

            'username' => ['nullable','string','max:150',],

            'email' => ['required','email','max:255','unique:users,email',],

            'phone' => ['nullable','string','max:30',],

            'address' => ['nullable','string','max:1000',],

            'role' => ['required',Rule::in(['Admin', 'Developer']),],

            'status' => ['required',Rule::in(['Active', 'Inactive']),],

            'password' => ['required','string','min:8','confirmed',],

            'profile_picture' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048',],
        ]);

        /* Profile picture*/

        if ($request->hasFile('profile_picture')) 
            {
                $validated['profile_picture'] = $request->file('profile_picture')
                                                ->store('profile-pictures', 'public');
            }

        /* Create user */

        User::create($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User account created successfully.');
    }

    /**
     * Display one user's details.
     */
    public function show(User $user): View
    {
        return view('admin.view-user', compact('user'));
    }

    /**
     * Display the Edit User page.
     */
    public function edit(User $user): View
    {
        return view('admin.edit-user', compact('user'));
    }

    /* Update an existing user.*/

    public function update( Request $request, User $user): RedirectResponse 
    {
        $validated = $request->validate
        ([
            'userid' => ['required', 'string', 'max:30',],
            
            'fullname' => ['required', 'string', 'max:130',],

            'username' => ['nullable','string','max:150',],

            'email' => ['required','email','max:255',

                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],

            'phone' => ['nullable','string','max:30',],

            'address' => [ 'nullable','string','max:1000',],

            'role' => [ 'required', Rule::in(['Admin', 'Developer']),
            ],

            'status' => [ 'required', Rule::in(['Active', 'Inactive']),
            ],

            'password' => ['nullable','string','min:8','confirmed',],

            'profile_picture' => ['nullable','image','mimes:jpg,jpeg,png,webp', 'max:2048',],
        ]);

        /* Protect the currently logged-in Admin*/

        if ($request->user()->is($user)) 
            {
                if ($validated['status'] === 'Inactive') 
                    {
                        return back()
                            ->withErrors([
                                'status' => 'You cannot deactivate your own account.',
                            ])->withInput();
            }

            if ($validated['role'] !== 'Admin') 
                {
                    return back()
                        ->withErrors([
                            'role' => 'You cannot remove your own Admin role.',
                        ])->withInput();
                }
        }

        /* Password
         If the password box is empty, keep the existing password.
        */

        if (empty($validated['password'])) 
            {
                unset($validated['password']);
            }

        /* Replace profile picture*/

        if ($request->hasFile('profile_picture')) 
            {
                if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) 
                {
                    Storage::disk('public')->delete($user->profile_picture);
                }

                $validated['profile_picture'] = $request->file('profile_picture')
                                                ->store('profile-pictures', 'public');
            }

        $user->update($validated);

        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', 'User information updated successfully.');
    }
}