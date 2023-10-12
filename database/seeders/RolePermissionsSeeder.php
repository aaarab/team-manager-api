<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            "users" => ["index", "show", "create", "update", "delete", "profile"],
            "employers" => ["index", "show", "create", "update", "delete"],
            "account" => ["index", "show", "create", "update", "delete"],
            "search" => ["index"],
        ];

        foreach ($permissions as $table => $actions) {
            foreach ($actions as $action) {
                Permission::create([
                    'guard_name' => 'api',
                    'name' => $table . '.' . $action,
                ]);
            }
        }

        Role::create([
            'guard_name' => 'api',
            'name' => 'admin'
        ]);

        $userRole = Role::create([
            'guard_name' => 'api',
            'name' => 'user',
        ]);

        $userRole->givePermissionTo(['users.profile']);
    }
}
