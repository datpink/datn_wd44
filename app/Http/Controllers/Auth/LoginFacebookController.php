<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginFacebookController extends Controller
{
    // Chuyển hướng đến Facebook để đăng nhập
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->scopes(['email'])->redirect();
    }

    // Xử lý callback từ Facebook
    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();

            // Lấy thông tin từ Facebook
            $facebookId = $facebookUser->getId();
            $email = $facebookUser->getEmail();
            $name = $facebookUser->getName();

            // Kiểm tra xem người dùng đã tồn tại chưa
            $user = User::where('email', $email)->first();

            if (!$user) {
                // Tạo người dùng mới nếu không tìm thấy
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'facebook_id' => $facebookId,
                ]);
            } else {
                // Cập nhật facebook_id nếu đã tồn tại người dùng
                $user->update(['facebook_id' => $facebookId]);
            }

            // Đăng nhập người dùng
            Auth::login($user);

            // Chuyển hướng sau khi đăng nhập
            return redirect('/home');
        } catch (\Exception $e) {
            return redirect('/login');
        }
    }
}
