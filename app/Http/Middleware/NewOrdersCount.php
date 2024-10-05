<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Order;

class NewOrdersCount
{
    public function handle($request, Closure $next)
    {
        // Đếm số lượng đơn hàng mới
        $newOrdersCount = Order::where('is_new', true)->count();

        // Chia sẻ biến với tất cả view
        view()->share('newOrdersCount', $newOrdersCount);

        return $next($request);
    }
}