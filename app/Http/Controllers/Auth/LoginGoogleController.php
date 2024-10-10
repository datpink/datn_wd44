<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginGoogleController extends Controller
{
    // Chuyển hướng người dùng đến trang đăng nhập Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Xử lý callback từ Google
    public function handleGoogleCallback()
    {
        try {
            // Lấy thông tin người dùng từ Google
            $googleUser = Socialite::driver('google')->stateless()->user();
            // dd($googleUser->id);
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                Auth::login($user);
                $user->update([
                    'google_id' => $googleUser->id, // Cập nhật Google ID nếu cần
                ]);
            } elseif (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => bcrypt('123456dummy'),
                ]);
                $user->assignRole('user');
                Auth::login($user);
            }

            // Chuyển hướng người dùng sau khi đăng nhập thành công
            return redirect()->intended('');
        } catch (\Exception $e) {
            return redirect('/shop/login')->withErrors('Something went wrong, please try again.');
        }
    }
}
