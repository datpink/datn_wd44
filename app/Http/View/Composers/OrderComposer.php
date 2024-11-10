<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Order;

class OrderComposer
{
    public function compose(View $view)
    {
        // Lấy danh sách đơn hàng mới
        $newOrders = Order::where('is_new', true)->with('user')->paginate(3);
        $newOrdersCount = $newOrders->count();

        // Truyền biến vào view
        $view->with(compact('newOrders', 'newOrdersCount'));
    }
}