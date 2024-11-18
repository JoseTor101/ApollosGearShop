<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckGroup
{
    /**
     * Handle an incoming request.
     *
     * @param  string  $group  The group to check (e.g., 'admin', 'user').
     */
    public function handle(Request $request, Closure $next, string $group): mixed
    {
        // Check if the user is logged in
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }

        $user = Auth::user();
        if (Auth::user() && Auth::user()->getIsAdmin() == '0') {
            return $next($request);
        }

        if (Auth::user() && Auth::user()->getIsAdmin() == '1') {
            return $next($request);
        }

        $user = Auth::user();
        if ($user->group !== $group) {
            return redirect()->route('home.index')->with('error', 'You do not have the required permissions to access this page.');
        }

        // return $next($request);
    }
}