<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable; 
use Illuminate\Notifications\Notifiable; 

class Passenger extends Authenticatable implements Auditable
{
    use SoftDeletes, HasFactory, Notifiable, \OwenIt\Auditing\Auditable;

    protected $auditInclude = [
        'title',
        'text',
        'date',
        'is_active'
    ];

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'image' => 'array',
    ];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
}
