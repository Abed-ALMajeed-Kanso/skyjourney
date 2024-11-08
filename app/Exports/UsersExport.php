<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::all(['id', 'name', 'email', 'password', 'created_at', 'updated_at']);
    }

    public function headings(): array
    {
        return [
            'ID',                     
            'Name',                   
            'Email',                
            'Password',               
            'Created At',             
            'Updated At',             
        ];
    }
}
