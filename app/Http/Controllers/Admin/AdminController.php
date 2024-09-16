<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login'); // Tạo view đăng nhập
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Kiểm tra nếu đã đăng nhập thành công
            if (Auth::user()->role_id == 1) { // Thay đổi từ hasRole thành kiểm tra role_id
                return redirect()->route('admin.index');
            } else {
                Auth::logout();
                return redirect()->back()->with('error', 'Bạn không có quyền truy cập.');
            }
        }

        return redirect()->back()->with('error', 'Email hoặc mật khẩu không hợp lệ.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    public function index()
    {
        $title = '';

        $catalogueCount = Catalogue::count();
        $orderCount = Order::count();

        return view('admin.index', compact('title', 'catalogueCount', 'orderCount'));
    }

    public function profile()
    {
        $title = 'Profile';

        return view('admin.profile', compact('title'));
    }
}
