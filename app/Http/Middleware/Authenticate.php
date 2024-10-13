<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function unauthenticated($request, array $guards)
    {
        if (in_array('passengers', $guards)) {
            return redirect()->route('login_passenger'); // Ensure this route exists
        }
    
        return redirect()->route('login'); // This is for users
    }
    
}
