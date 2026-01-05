<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $modules = config('modules');

        $adminRole = Role::firstOrCreate([
            'name' => 'superadmin',
            'guard_name' => 'admin',
        ]);

        foreach ($modules as $moduleKey => $module) {
            foreach ($module['permissions'] as $permission) {

                $permissionName = "{$moduleKey}.{$permission}";

                $perm = Permission::firstOrCreate([
                    'name' => $permissionName,
                    'guard_name' => 'admin',
                ]);

                // Assign to admin
                if (!$adminRole->hasPermissionTo($perm)) {
                    $adminRole->givePermissionTo($perm);
                }
            }
        }
    }
}
// php artisan db:seed --class=PermissionSeeder