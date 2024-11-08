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
            'password' => Hash::make($row[3]), 
            'created_at' => $row[4] ? \Carbon\Carbon::parse($row[6]) : null, 
            'updated_at' => $row[5] ? \Carbon\Carbon::parse($row[7]) : null, 
        ]);
    }
}
