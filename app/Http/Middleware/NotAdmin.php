<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra nếu người dùng đang đăng nhập và có vai trò admin
        if (Auth::check() && Auth::user()->role && Auth::user()->role->name === 'admin') {
            // Nếu là admin, trả về trang lỗi hoặc chuyển hướng
            return redirect()->route('client.index')->withErrors([
                'message' => 'Bạn không có quyền truy cập vào trang này.',
            ]);
        }

        return $next($request); // Tiếp tục xử lý request
    }
}
