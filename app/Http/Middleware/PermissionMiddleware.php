<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, $permission)
    {

        // Lấy guard_name của người dùng hiện tại
        $guardName = $request->user()->guard_name;

        // Kiểm tra quyền với guard_name
        if (! $request->user()->hasPermissionTo($permission, $guardName)) {
            // Trả về lỗi 403 nếu không có quyền với guard_name cụ thể
            abort(403, 'Unauthorized action for guard: ' . $guardName);
        }

        // Nếu có quyền, tiếp tục xử lý request
        return $next($request);
    }
}
