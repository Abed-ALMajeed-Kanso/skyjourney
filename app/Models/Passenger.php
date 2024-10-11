<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable; 
use OwenIt\Auditing\Auditable as AuditableTrait; 

class Passenger extends Model implements Auditable 
{
    use SoftDeletes, HasFactory, Notifiable, AuditableTrait;

    protected $dates = ['deleted_at'];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

}
