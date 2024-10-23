<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
     protected $except = [ // Disable CSRF for these API routes
     /*   'users', 
        'Get_user/*',  
        'api/Create_user',   
        'Update_user/*',     
        'Delete_user/*',    
        'passengers',
        'Get_passenger/*',
        'Create_passenger',
        'Update_passenger/*',
        'Delete_passenger/*',
        'flights',
        'Get_flight/*',
        'Create_flight',
        'Update_flight/*',
        'Delete_flight/*',
        'Get_passengers_By_flight/*',
        'login',
        'logout',
        'import_users', */
    ];
    
}
