<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ManagerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('admin') || $user->hasRole('manager') || $user->hasRole('viewer')) {
                return $next($request);
            }
        }

        return response(['success' => false, 'message' => 'Forbidden'], Response::HTTP_FORBIDDEN);
    }
}