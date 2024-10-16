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
        $facebookUser = Socialite::driver('facebook')->stateless()->user();
        // dd($facebookUser);
        $user = User::where('email', $facebookUser->email)->first();

        if ($user) {
            $user->update([
                'facebook_id' => $facebookUser->id,
            ]);
            Auth::login($user);
        }else if(!$user){
            $user = User::create([
                'name' => $facebookUser->name,
                'email' => $facebookUser->email,
                'password' => bcrypt('123456dummy'), // Bạn nên sử dụng một cách tạo mật khẩu an toàn hơn
                'facebook_id' => $facebookUser->id,
            ]);
            $user->assignRole('user');
            Auth::login($user);
        }
        return redirect('/');

    } catch (\Exception $e) {
        // Nếu có lỗi xảy ra, chuyển hướng về trang đăng nhập
        return redirect('shop/login')->withErrors(['error' => 'Có lỗi xảy ra khi đăng nhập qua Facebook.']);
    }
}

}
