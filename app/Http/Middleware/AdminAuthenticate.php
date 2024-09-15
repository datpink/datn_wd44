<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->hasRole(1)) { // Kiểm tra với vai trò là 1
            return $next($request);
        }

        return redirect()->route('admin.login'); // Chuyển hướng nếu không phải admin
    }
}
