<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class SetLocaleMiddleware
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
        // Optionally, check the user's preferred language (e.g., from a user model or request)
        $locale = $request->get('lang', 'en'); // Default to 'en' if no 'lang' param is provided
        app()->setLocale($locale);

        return $next($request);
    }
}
