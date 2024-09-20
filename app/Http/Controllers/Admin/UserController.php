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
    public function index(Request $request)
    {
        $title = 'Danh Sách Người Dùng';
        $users = User::with('roles')->paginate(10);
        return view('admin.users.index', compact('users', 'title'));
    }

    // Hiển thị form thêm mới người dùng
    public function create()
    {
        $title = 'Thêm Mới Người Dùng';
        $roles = Role::all(); // Lấy danh sách vai trò
        return view('admin.users.create', compact('title', 'roles'));
    }

    // Xử lý lưu thông tin người dùng mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'status' => 'required|in:locked,unlocked', // Kiểm tra trạng thái
        ]);

        // Tạo người dùng
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status, // Lưu trạng thái
        ]);

        // Gán vai trò cho người dùng mới (ID của vai trò "user")
        $user->roles()->attach(2); // Giả sử ID của vai trò "user" là 2

        return redirect()->route('users.index')->with('success', 'Người dùng đã được thêm thành công!');
    }

    public function edit($id)
    {
        $title = 'Chỉnh Sửa Người Dùng';
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all(); // Lấy danh sách vai trò
        return view('admin.users.edit', compact('title', 'user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'roles' => 'required|array',
            'status' => 'required|in:locked,unlocked', // Kiểm tra trạng thái
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

        // Cập nhật vai trò
        $user->roles()->sync($request->roles);

        return redirect()->route('users.index')->with('success', 'Người dùng đã được cập nhật thành công!');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // Xóa mềm người dùng

        return redirect()->route('users.index')->with('success', 'Người dùng đã được xóa thành công!');
    }

    public function trash()
    {
        $users = User::onlyTrashed()->get();
        return view('admin.users.trash', compact('users'));
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore(); // Khôi phục người dùng

        return redirect()->route('users.trash')->with('success', 'Người dùng đã được khôi phục thành công!');
    }

    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete(); // Xóa cứng người dùng

        return redirect()->route('users.trash')->with('success', 'Người dùng đã được xóa cứng thành công!');
    }
}