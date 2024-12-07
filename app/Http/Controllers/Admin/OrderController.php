<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductVariant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use PDF;
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
        $query = Order::query();

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

        // Lọc theo ngày
        if ($request->has('date') && $request->date) {
            $query->whereDate('created_at', $request->date);
        }

        // Lọc theo khoảng thời gian
        if ($request->has('date_filter') && $request->date_filter) {
            switch ($request->date_filter) {
                case 'yesterday':
                    $query->whereDate('created_at', Carbon::yesterday());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'last_week':
                    $query->whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', Carbon::now()->month);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', Carbon::now()->subMonth()->month);
                    break;
            }
        }

        // Lọc theo trạng thái
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Lọc theo trạng thái thanh toán
        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->paginate(10); // Lấy danh sách đơn hàng

        return view("admin.orders.index", compact("orders", "title"));
    }

    public function newOrders(Request $request)
    {
        $title = 'Đơn Hàng Mới';

        $query = Order::query();

        // Chỉ lấy các đơn hàng mới
        $query->where('is_new', true);

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

        // Lọc theo ngày
        if ($request->has('date') && $request->date) {
            $query->whereDate('created_at', $request->date);
        }

        // Lọc theo khoảng thời gian
        if ($request->has('date_filter') && $request->date_filter) {
            switch ($request->date_filter) {
                case 'yesterday':
                    $query->whereDate('created_at', Carbon::yesterday());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'last_week':
                    $query->whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', Carbon::now()->month);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', Carbon::now()->subMonth()->month);
                    break;
            }
        }

        // Lọc theo trạng thái
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Lọc theo trạng thái thanh toán
        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        // Phân trang kết quả
        $newOrders = $query->with('user')->paginate(10);

        return view('admin.orders.new', compact('newOrders', 'title'));
    }



    public function show($id)
    {
        $title = 'Chi Tiết Đơn Hàng';

        // Lấy đơn hàng với các thông tin cần thiết (user, orderItems, product và productVariant)
        $order = Order::with([
            'user',
            'orderItems.productVariant.product', // Nếu có biến thể
            'orderItems.product' // Nếu không có biến thể
        ])->findOrFail($id);

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
    public function showOrderHistory()
    {
        // Lấy ID người dùng hiện tại
        $userId = Auth::id();

        // Lấy danh sách đơn hàng của người dùng
        $orders = Order::with([
            'user',
            'items.productVariant.product.brand', // Thông qua productVariant
            'items.product.brand' // Trực tiếp từ product
        ])
            ->withSum('items', 'total') // Tổng tiền từng đơn hàng
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Xử lý thuộc tính biến thể nếu có
        foreach ($orders as $order) {
            $items = $order->items;

            // Chỉ lấy thuộc tính cho các sản phẩm có biến thể
            $productVariantAttributes = DB::table('product_variant_attributes as pva')
                ->join('attribute_values as av', 'pva.attribute_value_id', '=', 'av.id')
                ->join('attributes as a', 'av.attribute_id', '=', 'a.id')
                ->whereIn('pva.product_variant_id', $items->pluck('product_variant_id')->filter()->toArray())
                ->select('pva.product_variant_id', 'a.name as attribute_name', 'av.name as attribute_value')
                ->get();

            $order->groupedVariantAttributes = $productVariantAttributes->groupBy('product_variant_id');
        }

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

    public function generateInvoice($id)
    {
        $order = Order::with('orderItems.productVariant')->findOrFail($id);

        // Tạo PDF
        $pdf = PDF::loadView('admin.orders.invoice', compact('order'));

        // Trả về PDF
        return $pdf->download('invoice_' . $order->id . '.pdf');
    }

    public function cancel(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Các trạng thái không cho phép hủy
        $nonCancelableStatuses = ['shipped', 'canceled', 'refunded', 'Delivering'];

        // Kiểm tra trạng thái đơn hàng có thể hủy
        if (in_array($order->status, $nonCancelableStatuses)) {
            return redirect()->back()->with('error', 'Không thể hủy đơn hàng này.');
        }

        // Cập nhật trạng thái và lý do hủy
        $order->status = 'canceled';
        $order->cancellation_reason = $request->input('cancellation_reason');
        $order->canceled_at = now();
        $order->save();

        // Hoàn lại stock cho từng sản phẩm trong đơn hàng
        foreach ($order->orderItems as $orderItem) {
            if ($orderItem->product_variant_id) {
                // Nếu sản phẩm có biến thể, hoàn lại stock vào product_variant
                $productVariant = ProductVariant::find($orderItem->product_variant_id);
                if ($productVariant) {
                    $productVariant->stock += $orderItem->quantity; // Hoàn lại số lượng vào product_variant
                    $productVariant->save();

                    // Đồng thời, cập nhật stock của sản phẩm chính
                    $product = $productVariant->product;  // Lấy sản phẩm chính từ product_variant
                    if ($product) {
                        $product->stock += $orderItem->quantity; // Hoàn lại số lượng vào sản phẩm chính
                        $product->save();
                    }
                }
            } else {
                // Nếu sản phẩm không có biến thể, hoàn lại stock vào product
                $product = $orderItem->product;
                if ($product) {
                    $product->stock += $orderItem->quantity; // Hoàn lại số lượng vào product
                    $product->save();
                }
            }
        }

        // Quay lại trang lịch sử đơn hàng với thông báo thành công
        return redirect()->route('order.history', ['userId' => $order->user_id])->with('success', 'Đơn hàng đã được hủy thành công và số lượng sản phẩm đã được hoàn lại vào kho.');
    }




    // public function refund(Request $request, $id)
    // {
    //     // Tìm đơn hàng theo ID
    //     $order = Order::findOrFail($id);

    //     // Kiểm tra trạng thái đơn hàng, chỉ cho phép trả hàng nếu trạng thái là 'delivered'
    //     if ($order->status !== 'delivered') {
    //         return redirect()->back()->with('error', 'Chỉ đơn hàng đã giao mới có thể trả hàng.');
    //     }

    //     // Trước khi cập nhật trạng thái
    //     Log::info('Trạng thái trước khi cập nhật: ' . $order->status);

    //     // Lưu lý do trả hàng
    //     $order->refund_reason = $request->input('refund_reason');
    //     $order->status = 'returned';  // Cập nhật trạng thái đơn hàng thành 'refunded'
    //     $order->payment_status = 'refunded';  // Cập nhật trạng thái thanh toán thành 'failed'

    //     // Xử lý hình ảnh trả hàng (nếu có)
    //     if ($request->hasFile('refund_image')) {
    //         $images = $request->file('refund_image');
    //         $imagePaths = [];

    //         foreach ($images as $image) {
    //             // Lưu hình ảnh vào thư mục 'refunds' trong storage
    //             $imagePaths[] = $image->store('refunds', 'public');
    //         }

    //         // Lưu đường dẫn các hình ảnh vào database dưới dạng JSON
    //         $order->refund_images = json_encode($imagePaths);
    //     }

    //     // Lưu các thay đổi vào cơ sở dữ liệu
    //     $order->save();

    //     // Sau khi lưu
    //     Log::info('Trạng thái sau khi cập nhật: ' . $order->status);
    //     Log::info('Trạng thái thanh toán sau khi cập nhật: ' . $order->payment_status);

    //     // Quay lại trang lịch sử đơn hàng với thông báo thành công
    //     return redirect()->route('order.history', ['userId' => $order->user_id])->with('success', 'Đơn hàng đã được hoàn trả và trạng thái thanh toán đã được cập nhật.');
    // }
    public function refund(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'delivered') {
            return redirect()->back()->with('error', 'Chỉ đơn hàng đã giao mới có thể trả hàng.');
        }

        // Lưu lý do trả hàng
        $order->refund_reason = $request->input('refund_reason');
        $order->refund_method = $request->input('refund_method', 'store_credit');

        // Chuyển trạng thái thanh toán sang 'refunded'
        $order->payment_status = 'refunded';
        $order->admin_status = 'pending';

        // Nếu phương thức hoàn tiền là 'store_credit', xử lý tải lên QR và số tài khoản
        if ($order->refund_method === 'store_credit') {
            // Kiểm tra nếu có tải QR
            if ($request->hasFile('qr_code')) {
                $order->qr_code = $request->file('qr_code')->store('qr_codes', 'public');
            }

            // Lưu số tài khoản (nếu có)
            $order->account_number = $request->input('account_number', '');
        }

        // Xử lý hình ảnh trả hàng (nếu có)
        if ($request->hasFile('refund_image')) {
            $images = $request->file('refund_image');
            $imagePaths = [];

            foreach ($images as $image) {
                $imagePaths[] = $image->store('refunds', 'public');
            }

            $order->refund_images = json_encode($imagePaths);
        }

        $order->refund_at = now();

        $order->save();

        return redirect()->route('order.history', ['userId' => $order->user_id])
            ->with('success', 'Yêu cầu hoàn trả đã được gửi và đang chờ duyệt.');
    }


    public function approveRefund($id)
    {
        // Tìm đơn hàng theo ID
        $order = Order::with('orderItems.productVariant.product')->findOrFail($id);

        // Kiểm tra trạng thái đơn hàng để đảm bảo hợp lệ
        if ($order->status !== 'delivered') {
            return redirect()->back()->with('error', 'Chỉ đơn hàng đã giao mới có thể xác nhận hoàn trả.');
        }

        // Cập nhật trạng thái đơn hàng
        $order->status = 'returned';
        $order->payment_status = 'refunded';  // Trạng thái thanh toán
        $order->admin_status = 'approved';   // Trạng thái duyệt
        $order->refund_at = now();           // Ghi lại thời gian hoàn trả

        // Hoàn lại stock cho từng sản phẩm/biến thể trong đơn hàng
        foreach ($order->orderItems as $orderItem) {
            if ($orderItem->product_variant_id) {
                // Nếu sản phẩm có biến thể
                $productVariant = ProductVariant::find($orderItem->product_variant_id);
                if ($productVariant) {
                    $productVariant->stock += $orderItem->quantity;
                    $productVariant->save();

                    // Đồng thời cập nhật stock sản phẩm chính
                    $product = $productVariant->product;
                    if ($product) {
                        $product->stock += $orderItem->quantity;
                        $product->save();
                    }
                }
            } else {
                // Nếu sản phẩm không có biến thể
                $product = $orderItem->product;
                if ($product) {
                    $product->stock += $orderItem->quantity;
                    $product->save();
                }
            }
        }

        // Lưu đơn hàng
        $order->save();

        // Quay lại với thông báo thành công
        return back()->with('success', 'Hoàn tiền đã được duyệt, kho hàng đã được cập nhật, và trạng thái đơn hàng chuyển thành trả hàng.');
    }


    public function rejectRefund($id)
    {
        // Tìm đơn hàng theo ID
        $order = Order::findOrFail($id);

        // Từ chối hoàn trả, khôi phục trạng thái thanh toán ban đầu
        $order->payment_status = 'paid';  // Trạng thái thanh toán quay lại 'paid' (hoàn thành)
        $order->admin_status = 'rejected';   // Đặt trạng thái admin là 'rejected' (bị từ chối)

        // Không lưu hình ảnh hay lý do hoàn trả khi từ chối
        $order->refund_reason = null;
        $order->refund_images = null;
        $order->refund_at = null;  // Xóa th��i gian hoàn trả
        $order->qr_code = null;
        $order->account_number = null;  // Xóa số tài khoản

        $order->save();

        // Quay lại trang trước với thông báo từ chối
        return back()->with('success', 'Hoàn tiền đã bị từ chối và trạng thái thanh toán đã được khôi phục.');
    }


    // OrderController.php
    // app/Http/Controllers/OrderController.php

    // app/Http/Controllers/Admin/OrderController.php

    public function confirmDelivered($id)
    {
        DB::beginTransaction();
        try {
            $order = Order::findOrFail($id);

            // Kiểm tra nếu trạng thái đơn hàng không phải 'pending_delivery'
            if ($order->status !== 'pending_delivery') {
                \Log::error('Trạng thái không hợp lệ', ['order_id' => $id, 'status' => $order->status]);
                return response()->json(['success' => false, 'message' => 'Trạng thái đơn hàng không hợp lệ.'], 400);
            }

            // Cập nhật trạng thái và lưu
            $order->status = 'delivered';
            $order->payment_status = 'paid';
            $order->delivered_at = now();
            $order->save();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Đơn hàng đã được xác nhận là đã nhận!']);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Lỗi khi cập nhật trạng thái', ['order_id' => $id, 'error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Có lỗi khi cập nhật trạng thái đơn hàng.'], 500);
        }
    }

}
