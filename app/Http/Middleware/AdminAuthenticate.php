<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            info('User ID: ' . Auth::id());
                return $next($request);
        }

        return redirect()->route('admin.login');
    }
}
