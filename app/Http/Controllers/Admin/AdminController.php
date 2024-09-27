<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Hiển thị form đăng nhập cho Admin
    public function showLoginForm()
    {
        return view('admin.login'); // Tạo view đăng nhập
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        // Thực hiện đăng nhập
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            info('User logged in: ' . $user->email);

            // Kiểm tra trạng thái tài khoản
            if ($user->status === 'locked') {
                Auth::logout(); // Đăng xuất nếu tài khoản bị khóa
                return redirect()->back()->with('error', 'Tài khoản của bạn đã bị khóa.');
            }

            // Kiểm tra vai trò và phân quyền
            if ($user->hasRole('super_admin')) {
                return redirect()->route('admin.index'); // Điều hướng đến trang admin
            } elseif ($user->hasRole('editor')) {
                return redirect()->route('admin.index'); // Điều hướng đến trang editor
            } elseif ($user->hasRole('user')) {
                return redirect()->route('client.index'); // Điều hướng đến trang editor
            } else {
                Auth::logout(); // Đăng xuất nếu không có quyền phù hợp
                return redirect()->back()->with('error', 'Bạn không có quyền truy cập.');
            }
        }

        info('Login failed for: ' . $request->email);
        return redirect()->back()->with('error', 'Email hoặc mật khẩu không hợp lệ.');
    }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); // Xóa session
        $request->session()->regenerateToken(); // Regenerate CSRF token
        return redirect()->route('admin.login');
    }

    // Trang chính của admin
    public function index()
    {
        $title = 'Trang Quản Trị';
        $catalogueCount = Catalogue::count();
        $orderCount = Order::count();
        $userCount = User::count();

        return view('admin.index', compact('title', 'catalogueCount', 'orderCount', 'userCount'));
    }

    // Hiển thị thông tin cá nhân của admin
    public function profile()
    {
        $title = 'Thông Tin Cá Nhân';
        return view('admin.profile', compact('title'));
    }

    // Quản lý người dùng (phân quyền)
    public function manageUsers()
    {
        $title = 'Quản Lý Người Dùng';
        $users = User::with('roles')->paginate(10); // Lấy danh sách người dùng kèm theo vai trò của họ
        return view('admin.users.index', compact('users', 'title'));
    }

    // Cập nhật vai trò người dùng
    public function updateUserRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'role' => 'required|string|exists:roles,name', // Kiểm tra vai trò hợp lệ
        ]);

        // Cập nhật vai trò người dùng
        $user->syncRoles($request->role);

        return redirect()->route('admin.users.index')->with('success', 'Vai trò của người dùng đã được cập nhật.');
    }
}
