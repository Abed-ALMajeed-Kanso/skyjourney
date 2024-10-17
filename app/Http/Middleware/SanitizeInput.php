<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

        // Log the input for debugging purposes
        Log::info('Input before sanitization: ', $input);

        // Sanitize each input value only if it exists
        if (!empty($input)) {
            array_walk_recursive($input, function (&$value) {
                // Sanitize value
                $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            });
        }

        // Replace the request input with sanitized values
        $request->merge($input);

        // Check if the method is allowed
        if (!in_array($request->method(), ['GET', 'POST', 'PUT', 'DELETE'])) {
            return response()->json(['error' => 'Method not allowed'], 405);
        }

        return $next($request);
    }
}
