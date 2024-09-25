<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::orderByDesc('id')->paginate('20');
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'guard_name' => 'required|string|max:255',
            'group' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        Permission::create($request->all());

        return redirect()->route('permissions.index')->with('success', 'Quyền đã được tạo thành công.');
    }


    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'guard_name' => 'required|string|max:255',
            'group' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $permission->update($request->all());

        return redirect()->route('permissions.index')->with('success', 'Quyền đã được cập nhật thành công.');
    }


    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
