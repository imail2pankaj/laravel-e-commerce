<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run()
    {
        // Permissions for admin guard
        $permissions = [
            'create.user',
            'edit.user',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'admin']
            );
        }

        // Get superadmin role
        $superadmin = Role::where('name', 'superadmin')->where('guard_name', 'admin')->first();

        // Assign all permissions to superadmin
        if ($superadmin) {
            $superadmin->givePermissionTo($permissions);
        }
    }
}
