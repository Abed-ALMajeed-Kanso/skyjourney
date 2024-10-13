<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Check if the user has the admin role
            $user = Auth::user();
            if ($user->hasRole('admin')) { // Assuming you have a method `hasRole`
                return $next($request);
            }
        }

        // If the user is not admin or not authenticated
        return response()->json(['message' => 'Forbidden'], 403);
    }
}