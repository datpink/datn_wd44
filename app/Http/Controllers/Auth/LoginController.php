<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Hiện thị form đăng nhập
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Kiểm tra thông tin đăng nhập
        if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
            // Lấy thông tin người dùng
            $user = Auth::user();

            // Kiểm tra trạng thái
            if ($user->status === 'locked') {
                Auth::logout(); // Đăng xuất nếu tài khoản bị khóa
                return back()->withErrors([
                    'username' => 'Tài khoản của bạn đã bị khóa.',
                ]);
            }

            // Kiểm tra vai trò của người dùng
            if ($user->hasRole('admin')) {
                Auth::logout(); // Đăng xuất người dùng admin
                return back()->withErrors([
                    'username' => 'Tài khoản của bạn không thể đăng nhập vào client vì là admin.',
                ]);
            }

            // Đăng nhập thành công, chuyển hướng người dùng đến trang chủ
            return redirect()->route('client.index'); // Sử dụng route name
        }

        // Đăng nhập không thành công, quay lại với thông báo lỗi
        return back()->withErrors([
            'username' => 'Thông tin đăng nhập không chính xác.',
        ]);
    }


    public function logout(Request $request)
    {
        Auth::logout(); // Đăng xuất người dùng
        return redirect()->route('client.index'); // Chuyển hướng đến trang chủ
    }
}