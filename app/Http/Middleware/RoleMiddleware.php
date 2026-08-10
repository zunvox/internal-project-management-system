<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        //Confirm that the user is logged in
        if (! $request->user())
            {
                return redirect()->route('login');
            }

            //Confirm that the user's account is still active.
            if (! $request->user()->isActive())
                {
                    abort(403, 'Your account is inactive.');
                }

            //Confirm the user's role matches the required role.
            if ($request->user()->role !== $role)
                {
                    abort(403, 'You are not authorised to access this page.');
                }

                //Allow the request to continue.
                return $next($request);
    }
}
