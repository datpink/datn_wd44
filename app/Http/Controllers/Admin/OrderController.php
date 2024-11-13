<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderItem;
use App\Traits\ManagesOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use ManagesOrders;

    public function index(Request $request)
    {
        $title = 'Danh Sách Đơn Hàng';

        // // Lấy danh sách đơn hàng mới
        // $newOrders = Order::where('is_new', true)->with('user')->get();
        // $newOrderIds = $newOrders->pluck('id')->toArray(); // Lấy ID đơn hàng mới
        // $newOrdersCount = $newOrders->count(); // Đếm số lượng đơn hàng mới

        $query = Order::query();

        // // Kiểm tra xem có tham số status không
        // if ($request->has('status') && $request->status === 'new') {
        //     $query->where('is_new', true); // Lọc chỉ các đơn hàng mới
        // }

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

        return view("admin.orders.index", compact("orders", "title"));
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

    //Hiển thị danh sách lịch sử đơn hàng
    public function showOrderHistory($userId)
    {
        $userId = Auth::id();

        // Truy vấn lấy danh sách đơn hàng của người dùng với tổng tiền mỗi đơn hàng theo order_id
        $orders = Order::withSum('items', 'total')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.user.order-history', compact('orders'));
    }
    public function detailOrderHistory(Order $order)
    {
        // Lấy thông tin người mua
        $buyer = $order->user;

        // Lấy chi tiết các sản phẩm trong đơn hàng cùng với thông tin biến thể
        $items = $order->items()->with('productVariant')->get();

        // Lấy các biến thể cho từng sản phẩm trong đơn hàng từ bảng `product_variant_attributes`
        $productVariantAttributes = DB::table('product_variant_attributes as pva')
            ->join('attribute_values as av', 'pva.attribute_value_id', '=', 'av.id')
            ->join('attributes as a', 'av.attribute_id', '=', 'a.id')
            ->whereIn('pva.product_variant_id', $items->pluck('product_variant_id')->toArray())
            ->select('pva.product_variant_id', 'a.name as attribute_name', 'av.name as attribute_value') // Đổi 'av.value' thành 'av.name'
            ->get();

        // Gom nhóm các thuộc tính biến thể theo `product_variant_id`
        $groupedVariantAttributes = $productVariantAttributes->groupBy('product_variant_id');

        // Trả về view với dữ liệu đơn hàng, bao gồm chi tiết biến thể
        return view('client.user.order-detail', compact('order', 'items', 'buyer', 'groupedVariantAttributes'));
    }
}
