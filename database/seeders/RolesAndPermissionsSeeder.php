<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Tạo các quyền
        $permissions = [
            'view items',
            'edit items',
            'delete items',
            'create items',
            'full',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Tạo các vai trò
        $roles = [
            'admin',
            'editor',
            'user',
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role, 'guard_name' => 'web']);
        }

        // Gán quyền cho vai trò
        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo(Permission::all());

        $editorRole = Role::findByName('editor');
        $editorRole->givePermissionTo(['view items', 'edit items']);

        $userRole = Role::findByName('user');
        $userRole->givePermissionTo('view items');
    }
}
