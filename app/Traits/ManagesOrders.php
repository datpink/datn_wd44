<?php

namespace App\Traits;

use App\Models\Order;
use Illuminate\Http\Request;

trait ManagesOrders
{
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->status = $request->input('status');
        $order->save();

        return redirect()->route('orders.index')
                         ->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }

}

