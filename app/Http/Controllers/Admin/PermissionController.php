<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
{

    $title = 'Danh Sách Quyền Hạn';
    $permissions = Permission::all();

    return view('admin.permissions.index', compact('permissions', 'title'));
}


    public function create()
    {
        $title = 'Thêm Mới Quyền Hạn';
        return view('admin.permissions.create', compact('title'));
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
        $title = 'Chỉnh Sửa Quyền Hạn';
        return view('admin.permissions.edit', compact('permission', 'title'));
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
