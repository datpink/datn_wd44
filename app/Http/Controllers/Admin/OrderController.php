<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Traits\ManagesOrders;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ManagesOrders;

    public function index(Request $request)
    {
        $title = 'Danh Sách Đơn Hàng';

        // Lấy danh sách đơn hàng mới
        $newOrders = Order::where('is_new', true)->get();
        $newOrderIds = $newOrders->pluck('id')->toArray(); // Lấy ID đơn hàng mới
        $newOrdersCount = $newOrders->count(); // Đếm số lượng đơn hàng mới

        $query = Order::query();

        // Kiểm tra xem có tham số status không
        if ($request->has('status') && $request->status === 'new') {
            $query->where('is_new', true); // Lọc chỉ các đơn hàng mới
        }

        // Tìm kiếm (nếu có)
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('paymentMethod', function ($paymentMethodQuery) use ($search) {
                        $paymentMethodQuery->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhere('status', 'like', '%' . $search . '%');
            });
        }

        $orders = $query->paginate(10); // Lấy danh sách đơn hàng

        return view("admin.orders.index", compact("orders", "title", "newOrdersCount", "newOrderIds"));
    }



    public function show($id)
    {
        $title = 'Chi Tiết Đơn Hàng';

        $order = Order::with(['user', 'orderItems.productVariant.product'])->findOrFail($id);

        // Đánh dấu đơn hàng là đã được xem
        $order->is_new = false;
        $order->save();

        return view('admin.orders.show', compact('order', 'title'));
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Đơn hàng đã được xóa thành công!');
    }

    public function trash()
    {
        $title = 'Thùng Rác';
        $orders = Order::onlyTrashed()->get();
        return view('admin.orders.trash', compact('orders', 'title'));
    }

    public function restore($id)
    {
        $order = Order::withTrashed()->findOrFail($id);
        $order->restore();
        return redirect()->route('orders.trash')
            ->with('success', 'Đơn hàng đã được khôi phục thành công!');
    }

    public function forceDelete($id)
    {
        $order = Order::withTrashed()->findOrFail($id);
        $order->forceDelete();
        return redirect()->route('orders.trash')
            ->with('success', 'Đơn hàng đã được xóa cứng!');
    }
}
