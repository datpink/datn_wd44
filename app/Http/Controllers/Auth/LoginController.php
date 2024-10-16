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

    // Lấy thông tin đăng nhập (sử dụng 'email' hoặc 'username')
    $credentials = ['email' => $request->username, 'password' => $request->password];

    // Kiểm tra xem checkbox 'rememberme' có được chọn không
    $remember = $request->has('rememberme') ? true : false;

    // Kiểm tra thông tin đăng nhập
    if (Auth::attempt($credentials, $remember)) {
        // Lấy thông tin người dùng sau khi đăng nhập thành công
        $user = Auth::user();
        info('User logged in: ' . $user->email);

        // Kiểm tra trạng thái tài khoản
        if ($user->status === 'locked') {
            Auth::logout(); // Đăng xuất nếu tài khoản bị khóa
            return redirect()->back()->withErrors(['username' => 'Tài khoản của bạn đã bị khóa.']);
        }

        // Kiểm tra vai trò của người dùng và điều hướng đến trang phù hợp
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.index'); // Điều hướng đến trang admin
        } elseif ($user->hasRole('editor')) {
            return redirect()->route('editor.index'); // Điều hướng đến trang editor
        } elseif ($user->hasRole('user')) {
            return redirect()->route('client.index'); // Điều hướng đến trang client
        }

        // Nếu không có quyền truy cập phù hợp, đăng xuất và thông báo lỗi
        Auth::logout();
        return redirect()->back()->withErrors(['username' => 'Bạn không có quyền truy cập.']);
    }

    // Đăng nhập không thành công, quay lại với thông báo lỗi
    info('Login failed for: ' . $request->username);
    return redirect()->back()->withErrors(['username' => 'Email hoặc mật khẩu không chính xác.']);
}


    public function logout(Request $request)
    {
        Auth::logout(); // Đăng xuất người dùng
        return redirect()->route('client.index'); // Chuyển hướng đến trang chủ
    }
}
