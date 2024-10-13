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
    protected $except = [
        'users', // Disable CSRF for these API routes
        'users/*',
        'login',
        'logout',
        'login_passenger',
        'logout_passenger',
        'import_users',
        'upload_image',
    ];
}
