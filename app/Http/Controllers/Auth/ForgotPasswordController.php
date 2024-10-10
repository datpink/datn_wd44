<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\DB;

class ForgotPasswordController extends Controller
{
    // Hiển thị form yêu cầu email để đặt lại mật khẩu
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    // Gửi link đặt lại mật khẩu
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email không tồn tại trong hệ thống']);
        }

        // Tạo token đặt lại mật khẩu
        $token = Str::random(60);

        // Lưu token vào cơ sở dữ liệu hoặc bảng `password_resets`
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        // Gửi email
        Mail::to($user->email)->send(new ResetPasswordMail($token));

        return back()->with('status', 'Link đặt lại mật khẩu đã được gửi tới email của bạn.');
    }


    // Hiển thị form đặt lại mật khẩu
    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    // Xử lý đặt lại mật khẩu
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required',
        ]);

        $reset = DB::table('password_resets')->where('token', $request->token)->first();

        if (!$reset) {
            return back()->withErrors(['token' => 'Token không hợp lệ']);
        }

        $user = User::where('email', $reset->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email không tồn tại trong hệ thống']);
        }

        // Đặt lại mật khẩu
        $user->password = Hash::make($request->password);
        $user->save();

        // Xóa token sau khi sử dụng
        DB::table('password_resets')->where('email', $user->email)->delete();

        return redirect()->route('login')->with('status', 'Mật khẩu đã được đặt lại thành công.');
    }
}
