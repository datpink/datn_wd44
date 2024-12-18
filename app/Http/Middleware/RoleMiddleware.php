<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
     /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Kiểm tra nếu người dùng không đăng nhập
        if (!$request->user()) {
            abort(403, 'Unauthorized action.');
        }

        // Kiểm tra nếu người dùng không có bất kỳ vai trò nào trong danh sách
        if (!$request->user()->hasAnyRole($roles)) {
            abort(403, 'Unauthorized action.');
        }

        // Tiếp tục xử lý nếu có vai trò hợp lệ
        return $next($request);
    }
}
