<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is logged in via session and has a valid role
        if (!session()->has('admin_id') || !in_array(session('role'), ['admin', 'moderator'])) {
            return redirect()->route('signin')->with('error', 'You must be an admin or moderator to access this page.');
        }

        return $next($request);
    }
}
