<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    public function model(array $row)
    {
        return new User([
            'id' => $row[0], 
            'name' => $row[1],
            'email' => $row[2],
            'email_verified_at' => $row[3] ? \Carbon\Carbon::parse($row[3]) : null, 
            'password' => Hash::make($row[4]),
            'remember_token' => $row[5],
            'created_at' => $row[6] ? \Carbon\Carbon::parse($row[6]) : null, 
            'updated_at' => $row[7] ? \Carbon\Carbon::parse($row[7]) : null, 
        ]);
    }
}
