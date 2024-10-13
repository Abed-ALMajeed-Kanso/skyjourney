<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable; 
use OwenIt\Auditing\Auditable as AuditableTrait; 
use Laravel\Sanctum\HasApiTokens;

class Passenger extends Authenticatable implements Auditable
{
    use SoftDeletes, HasFactory, AuditableTrait, HasApiTokens;

    protected $dates = ['deleted_at'];

    // Ensure that the image field can be accessed as an array
    protected $casts = [
        'image' => 'array',
    ];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
}
