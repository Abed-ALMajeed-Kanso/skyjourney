<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SanitizeInput
{
    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();
        Log::info('Input before sanitization: ', $input);
        if (!empty($input)) {
            array_walk_recursive($input, function (&$value) {
                $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            });
        }
        $request->merge($input);
        if (!in_array($request->method(), ['GET', 'POST', 'PUT', 'DELETE'])) {
            return response()->json(['error' => 'Method not allowed'], 405);
        }
        return $next($request);
    }
}
