<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    // Test to check if the users table contains the initial seeded records
    public function test_users_table_contains_specified_records()
    {
        // User::insert([
        //     [
        //         'name' => 'Admin User',
        //         'email' => 'veum.drew@example.org',
        //         'email_verified_at' => now(),
        //         'password' => Hash::make('password'),
        //         'remember_token' => Str::random(10),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Viewer User',
        //         'email' => 'clueilwitz@example.net',
        //         'email_verified_at' => now(),
        //         'password' => Hash::make('password'),
        //         'remember_token' => Str::random(10),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        // ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Admin User',
            'email' => 'veum.drew@example.org',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Viewer User',
            'email' => 'clueilwitz@example.net',
        ]);
    }
}
