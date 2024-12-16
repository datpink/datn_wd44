<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Response;

class CheckPendingOrdersMiddleware
{
    /**
     * Xử lý yêu cầu HTTP.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Gọi lệnh Artisan orders:check-pending khi middleware được chạy
        Artisan::call('orders:check-pending');

        // Tiếp tục xử lý yêu cầu
        return $next($request);
    }
}
