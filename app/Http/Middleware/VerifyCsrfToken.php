<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
     protected $except = [ // Disable CSRF for these API routes
        'users', 
        'users/*',  
        'Create_user',   
        'Update_user/*',     
        'Delete_user/*',    
        'passengers',
        'passengers/*',
        'Create_passenger',
        'Update_passenger/*',
        'Delete_passenger/*',
        'flights',
        'flights/*',
        'Create_flight',
        'Update_flight/*',
        'Delete_flight/*',
        'flights_passengers/*',
        'login',
        'logout',
        'import_users',
    ];
    
}
