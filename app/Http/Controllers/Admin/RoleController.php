<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'guard_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Role::create($validatedData);

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
{
    // Validate data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'guard_name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);
    $validatedData = $request->except('_token', 'permissions');

    // Update role information
    $update = $role->update($validatedData);

    if ($update && !empty($request->permissions)) {
        // Lấy danh sách tên quyền hiện tại của role (không phải ID)
        $permissionNames = $role->permissions->pluck('name')->toArray();

        // Thu hồi các quyền hiện tại
        if ($permissionNames) {
            $role->revokePermissionTo($permissionNames);
        }

        // Gán quyền mới từ request (nên là tên của quyền)
        $role->givePermissionTo($request->permissions);
    }

    return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
}


    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
