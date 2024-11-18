<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Order;

class OrderComposer
{
    public function compose(View $view)
    {
        // Đếm tổng số đơn hàng mới (không phân trang)
        $newOrdersCount = Order::where('is_new', true)->count();

        // Lấy danh sách đơn hàng mới và phân trang
        $newOrders = Order::where('is_new', true)
            ->with('user')
            ->paginate(3); // Phân trang 3 đơn hàng mỗi lần

        // Truyền biến vào view
        $view->with(compact('newOrders', 'newOrdersCount'));
    }

}