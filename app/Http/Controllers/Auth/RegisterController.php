<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
class RegisterController extends Controller
{
    public function register(Request $request)
{
    // Xác thực dữ liệu đầu vào
    $request->validate([
        'name'      => 'required|string|max:255',
        'email'     => 'required|email|unique:users,email',
        'password'  => 'required|min:6',
    ]);

    // Tạo người dùng mới
    $user = User::create([
        'name'          => $request->name,
        'email'         => $request->email,
        'password'      => Hash::make($request->password),
    ]);

    // Gán vai trò "user" cho người dùng mới
    $user->assignRole('user'); // Sử dụng phương thức assignRole()

    // Đăng nhập người dùng
    Auth::login($user);

    return redirect()->route('client.index')
                     ->with('success', 'Đăng ký thành công!');
}
}
