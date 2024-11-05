<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Flight extends Model implements Auditable 
{
    
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $auditInclude = [
        'title',
        'text',
        'date',
        'is_active'
    ];
    
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
