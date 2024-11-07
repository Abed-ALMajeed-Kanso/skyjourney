<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreventContentTypeSniffing
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
        $response = $next($request);

        // Add the X-Content-Type-Options header
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        return $response;
    }
}
