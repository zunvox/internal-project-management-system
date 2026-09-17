<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /* Show Profile Setting */

    public function edit(): View
    {
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    /* Update Personal Information */

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

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
                Rule::unique('users', 'username')->ignore($user->id),
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            'profile_picture' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
        ]);

        /* Replace Profile Picture */

        if ($request->hasFile('profile_picture')) {

            if (
                $user->profile_picture &&
                Storage::disk('public')->exists($user->profile_picture)
            ) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $validated['profile_picture'] = $request
                ->file('profile_picture')
                ->store('profile-pictures', 'public');
        }

        $user->update($validated);

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profile updated successfully.');
    }

    /* Update Password */

    public function updatePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => [
                'required',
                'current_password',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        $user->update([
            'password' => $validated['password'],
        ]);

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Password updated successfully.');
    }

    /* Delete Account */

    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'delete_password' => [
                'required',
            ],
        ]);

        $user = Auth::user();

        if (! Hash::check($request->delete_password, $user->password)) {
            return back()->withErrors([
                'delete_password' => 'The password you entered is incorrect.',
            ]);
        }

        /* For this system I recommend making the account inactive instead of physically deleting it. */

        $user->update([
            'status' => 'Inactive',
        ]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Your account has been deactivated.');
    }
}
