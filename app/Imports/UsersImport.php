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
            'created_at' => $row[3],
            'updated_at' => $row[4],
        ]);
    }
}
