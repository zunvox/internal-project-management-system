<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * * Display the login page
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Process the submitted login form.
     */
    public function store(Request $request): RedirectResponse
    {
        //Step 1: Validate the submitted form.
        $credentials = $request->validate([
            'email'=> [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'string',
            ],
        ]);

        //Step 2: Attempt to log the user in.
        if (! Auth::attempt($credentials, $request->boolean('remember')))
            {
                return back()
                ->withErrors([
                    'email' => 'The email or password is incorrect. ',
                ])
                -> onlyInput('email');
            }

            //Step 3: Get the authenticated user.
            $user = Auth::user();

            //Step 4: Prevent inactive user from entering the system
            if (! $user->isActive)
                {
                    Auth::logout();

                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return back()
                    ->withErrors([
                        'email' => 'Your account is inactive. Please contact the administrator.',
                    ])
                    ->onlyInput('email');
                }

                //Step 5: Regenerate the session for security
                $request->session()->regenerate();

                //Step 6: Redirect the user based on their role
                if ($user->isAdmin())
                    {
                        return redirect()->route('admin.dashboard');
                    }

                if ($user->isDeveloper())
                    {
                        return redirect()->route('developer.dashboard');
                    }

                    //Safety fallback if the user's role is not recognised.
                    Auth::logout();

                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return redirect()
                    ->route('login')
                    ->withErrors([
                        'email' => 'Your account does not have a valid role.',
                    ]); 
    }

    /**
     * Log the user out
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
        ->route('login')
        ->with('success', 'You have been logged out successfully.');
    }
}
