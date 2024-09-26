<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role; // Import model Role
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Hiển thị danh sách người dùng
    public function index()
    {
        $title = 'Danh Sách Người Dùng';
        $users = User::paginate(10);
        return view('admin.users.index', compact('users', 'title'));
    }

    // Hiển thị form thêm mới người dùng
    public function create()
    {
        $title = 'Thêm Mới Người Dùng';
        $roles = Role::all(); // Lấy tất cả vai trò
        return view('admin.users.create', compact('title', 'roles'));
    }

    // Lưu thông tin người dùng mới và gán vai trò
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'status' => 'required|in:locked,unlocked',
            'role' => 'required' // Kiểm tra role
        ]);

        // Tạo người dùng
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
        ]);

        // Gán vai trò cho người dùng
        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'Người dùng đã được thêm thành công!');
    }

    // Hiển thị form chỉnh sửa người dùng
    public function edit($id)
    {
        $title = 'Chỉnh Sửa Người Dùng';
        $user = User::findOrFail($id);
        $roles = Role::all(); // Lấy tất cả vai trò
        return view('admin.users.edit', compact('title', 'user', 'roles'));
    }

    // Cập nhật thông tin người dùng và vai trò
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:locked,unlocked', // Kiểm tra trạng thái
            'role' => 'required|string', // Thêm kiểm tra cho role
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->status = $request->status; // Cập nhật trạng thái

        // Cập nhật hình ảnh
        if ($request->hasFile('image')) {
            // Xóa hình ảnh cũ nếu có
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            // Lưu hình ảnh mới
            $user->image = $request->file('image')->store('user_images', 'public');
        }

        // Lưu thay đổi
        $user->save();

        // Gán vai trò mới cho người dùng
        $user->syncRoles([$request->role]); // Sử dụng syncRoles thay vì assignRole

        return redirect()->route('users.index')->with('success', 'Người dùng đã được cập nhật thành công!');
    }
}
