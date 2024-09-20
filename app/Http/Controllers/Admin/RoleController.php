<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Danh Sách Vai Trò';

        // Lấy giá trị tìm kiếm từ request
        $search = $request->input('search');

        // Tìm kiếm vai trò dựa trên tên
        $roles = Role::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->paginate(10);

        // Trả về view với dữ liệu cần thiết
        return view('admin.roles.index', compact('roles', 'search', 'title'));
    }

    public function create()
    {
        $title = 'Thêm Mới Vai Trò';

        return view('admin.roles.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Role::create($request->all());
        return redirect()->route('roles.index')->with('success', 'Vai trò đã được tạo thành công!');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required']);
        $role = Role::findOrFail($id);
        $role->update($request->all());
        return redirect()->route('roles.index')->with('success', 'Vai trò đã được cập nhật thành công!');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete(); // Xóa mềm vai trò
        return redirect()->route('roles.index')->with('success', 'Vai trò đã được xóa.');
    }

    public function trash()
    {
        $title = 'Thùng Rác Vai Trò';
        $roles = Role::onlyTrashed()->paginate(10); // Lấy các vai trò đã bị xóa

        return view('admin.roles.trash', compact('roles', 'title'));
    }

    public function restore($id)
    {
        $role = Role::onlyTrashed()->findOrFail($id);
        $role->restore(); // Khôi phục vai trò

        return redirect()->route('roles.trash')->with('success', 'Vai trò đã được khôi phục.');
    }

    public function forceDelete($id)
    {
        $role = Role::onlyTrashed()->findOrFail($id);
        $role->forceDelete(); // Xóa vĩnh viễn vai trò

        return redirect()->route('roles.trash')->with('success', 'Vai trò đã được xóa vĩnh viễn.');
    }
}