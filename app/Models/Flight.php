<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait; 
use Laravel\Sanctum\HasApiTokens;

class Flight extends Model implements Auditable 
{
    //la shu aayzinun?
    use HasFactory, AuditableTrait, HasApiTokens;

    protected $guarded = [];

    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
    ]; 

    public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }
    
}
