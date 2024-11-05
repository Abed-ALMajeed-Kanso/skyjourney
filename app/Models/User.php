<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;  
use Spatie\Permission\Traits\HasRoles; 

class User extends Authenticatable implements Auditable 
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles, \OwenIt\Auditing\Auditable;

    protected $auditInclude = [
        'title',
        'text',
        'date',
        'is_active'
    ];

    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

}
