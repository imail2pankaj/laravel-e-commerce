<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function editPermissions()
    {
        $roles = Role::where('guard_name', 'admin')->get();
        $permissions = Permission::where('guard_name', 'admin')->get();

        return view('admin.permission.permission-form', compact('roles', 'permissions'));
    }

    public function updatePermissions(Request $request)
    {
        $roles = Role::where('guard_name', 'admin')->get();

        foreach ($roles as $role) {
            $rolePermissions = $request->input('permissions.' . $role->id, []);

            // This now works correctly
            $role->syncPermissions($rolePermissions);
        }

        return redirect()->back()->with('success', 'Permissions updated successfully.');
    }
}
