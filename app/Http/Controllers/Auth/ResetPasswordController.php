<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class ResetPasswordController extends Controller
{
    public function create( Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email')
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate
        ([
            'token' => ['required'],

            'email' => ['required', 'email',],
            'password' => ['required', 'confirmed', Rules\Password::defaults(), ],
        ],
            
            [
            'token.required' => 'The password reset token is missing.',
            'password.required' => 'The new password is required.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $status = Password::reset(
            $request->only(
                'email', 'password', 'password_confirmation', 'token'
            ),

            function (User $user, string $password): void {
                $user ->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET)
            {
                return redirect()
                ->route('login')
                ->with(
                    'status',
                    'Your password has been reset successfully. Please log in using your new password.'
                );
            }

            return back()
            ->withErrors([
                'password' => __($status),
            ])
            ->withInput(
                $request->only('email')
            );
    }
}
