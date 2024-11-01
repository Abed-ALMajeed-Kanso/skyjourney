<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class BasicSeeder extends Seeder
{
    public function run()
    {
        // make sure admin the fisrt admin with api gaurd have id 1 
        // and the first viewer of api gaurd have id 2

        Role::insert([
            ['name' => 'admin', 'guard_name' => 'api', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'viewer', 'guard_name' => 'api', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'admin', 'guard_name' => 'sanctum', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'viewer', 'guard_name' => 'sanctum', 'created_at' => now(), 'updated_at' => now()],
        ]);

        Permission::insert([
            ['name' => 'view-users', 'guard_name' => 'api', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'view-user', 'guard_name' => 'api', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create-user', 'guard_name' => 'api', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'update-user', 'guard_name' => 'api', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete-user', 'guard_name' => 'api', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'import-users', 'guard_name' => 'api', 'created_at' => now(), 'updated_at' => now()],
        ]);

        Permission::insert([
            ['name' => 'view-passengers', 'guard_name' => 'api', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'view-passenger', 'guard_name' => 'api', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create-passenger', 'guard_name' => 'api', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'update-passenger', 'guard_name' => 'api', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete-passenger', 'guard_name' => 'api', 'created_at' => now(), 'updated_at' => now()],
        ]);

        Permission::insert([
            ['name' => 'view-flights', 'guard_name' => 'api', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'view-flight', 'guard_name' => 'api', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create-flight', 'guard_name' => 'api', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'update-flight', 'guard_name' => 'api', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete-flight', 'guard_name' => 'api', 'created_at' => now(), 'updated_at' => now()],
        ]);

        Permission::insert([
            ['name' => 'login', 'guard_name' => 'api', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'logout', 'guard_name' => 'api', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $adminRoleId = Role::where('name', 'admin')->first()->id;
        $adminPermissions = [
            'view-users',
            'view-user',
            'create-user',
            'update-user',
            'delete-user',
            'import-users',
            'view-passengers',
            'view-passenger',
            'create-passenger',
            'update-passenger',
            'delete-passenger',
            'view-flights',
            'view-flight',
            'create-flight',
            'update-flight',
            'delete-flight',
            'login',
            'logout',
        ];

        foreach ($adminPermissions as $permission) {
            $permissionId = Permission::where('name', $permission)->first()->id;
            DB::table('role_has_permissions')->insert([
                'role_id' => $adminRoleId,
                'permission_id' => $permissionId,
            ]);
        }

        $viewerRoleId = Role::where('name', 'viewer')->first()->id;
        $viewerPermissions = [
            'view-users',
            'view-user',
            'view-passengers',
            'view-passenger',
            'view-flights',
            'view-flight',
        ];

        foreach ($viewerPermissions as $permission) {
            $permissionId = Permission::where('name', $permission)->first()->id;
            DB::table('role_has_permissions')->insert([
                'role_id' => $viewerRoleId,
                'permission_id' => $permissionId,
            ]);
        }

        User::insert([
            [
                'name' => 'Admin User',
                'email' => 'veum.drew@example.org',
                'email_verified_at' => now(),
                'password' => Hash::make('password'), 
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Viewer User',
                'email' => 'clueilwitz@example.net',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $adminUser = User::where('email', 'admin@example.com')->first();
        $adminUser->assignRole('admin');

        $viewerUser = User::where('email', 'viewer@example.com')->first();
        $viewerUser->assignRole('viewer');
    }
}