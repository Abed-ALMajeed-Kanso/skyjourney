<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable; 
use OwenIt\Auditing\Auditable as AuditableTrait; 
use Illuminate\Notifications\Notifiable; 

class Passenger extends Authenticatable implements Auditable
{
    use SoftDeletes, HasFactory, AuditableTrait, Notifiable;

    protected $guarded = [];

    //use guarded instead of fillable
    protected $fillable = [
        'flight_id',
        'first_name',
        'last_name',
        'email',
        'password',
        'dob',
        'passport_expiry_date',
        'image',
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'image' => 'array',
    ];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
}
