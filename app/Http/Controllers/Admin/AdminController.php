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
    public function showLoginForm()
    {
        return view('admin.login'); // Tạo view đăng nhập
    }

    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt login
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            info('User logged in: ' . $user->email);

            if ($user->hasRole(1)) {
                return redirect()->route('admin.index');
            } else {
                Auth::logout();
                return redirect()->back()->with('error', 'Bạn không có quyền truy cập.');
            }
        }

        info('Login failed for: ' . $request->email);
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
        $userCount = User::count();

        return view('admin.index', compact('title', 'catalogueCount', 'orderCount', 'userCount'));
    }

    public function profile()
    {
        $title = 'Profile';
        return view('admin.profile', compact('title'));
    }
}