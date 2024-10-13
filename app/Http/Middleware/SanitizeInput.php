<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SanitizeInput
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
        // Retrieve all inputs from the request
        $input = $request->all();

        // Sanitize each input value
        array_walk_recursive($input, function (&$value) {
            $value = filter_var($value, FILTER_SANITIZE_STRING);
        });

        // Replace the request input with sanitized values
        $request->merge($input);

        return $next($request);
    }
}
