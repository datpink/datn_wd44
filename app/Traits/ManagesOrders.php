<?php

namespace App\Traits;

use App\Mail\OrderStatusUpdated;
use App\Models\Notification;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


trait ManagesOrders
{
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            // Lấy trạng thái hiện tại của đơn hàng từ DB với khóa hàng
            $order = Order::where('id', $id)->lockForUpdate()->firstOrFail();
            $newStatus = $request->input('status');
            $currentStatus = $order->status; // Trạng thái hiện tại trong DB

            // Kiểm tra trạng thái từ yêu cầu và trạng thái hiện tại trong DB
            if ($request->input('current_status') !== $currentStatus) {
                DB::rollBack();
                return redirect()->back()->withErrors([
                    'error' => 'Trạng thái đơn hàng đã bị thay đổi bởi người dùng khác. Vui lòng làm mới trang và thử lại!'
                ]);
            }

            // Danh sách trạng thái không cho phép cập nhật ngược
            $nonRevertibleStatuses = [
                'pending_delivery' => ['pending_confirmation', 'pending_pickup'], // Đang giao hàng không thể về Chờ xác nhận hoặc Chờ lấy hàng
                'pending_pickup' => ['pending_confirmation'], // Chờ lấy hàng không thể về Chờ xác nhận
            ];

            // Kiểm tra trạng thái hiện tại và trạng thái mới
            if (array_key_exists($currentStatus, $nonRevertibleStatuses) && in_array($newStatus, $nonRevertibleStatuses[$currentStatus])) {
                DB::rollBack();
                return redirect()->back()->withErrors([
                    'error' => 'Không thể chuyển từ trạng thái ' . __("statuses.$currentStatus") . ' về trạng thái ' . __("statuses.$newStatus") . '!'
                ]);
            }

            // Kiểm tra trạng thái cập nhật chỉ được phép là 'confirm_delivered'
            if ($newStatus === 'confirm_delivered') {
                // $order->payment_status = 'paid'; // Đánh dấu trạng thái đã xác nhận giao hàng
                $order->delivered_at = now(); // Cập nhật thời gian giao hàng
                $order->status = $newStatus;

                // dd($newStatus);
            } elseif (in_array($newStatus, ['pending_delivery', 'pending_pickup'])) {
                $order->status = $newStatus; // Đ��i trạng thái đơn hàng thành 'pending_delivery' hoặc 'pending_pickup'

            } elseif (in_array($newStatus, ['canceled', 'returned'])) {
                // Chỉ cập nhật nếu trạng thái là 'canceled' hoặc 'returned'
                $order->payment_status = 'refunded'; // Hoàn trả
                $order->refund_at = now(); // Cập nhật thời gian hoàn trả
                $order->status = $newStatus; // Đổi trạng thái đơn hàng thành 'canceled' hoặc 'returned'
            } elseif ($newStatus === 'pending_confirmation') {
                // Chuyển trạng thái về 'pending_confirmation'
                $order->payment_status = 'unpaid'; // Chưa thanh toán
                $order->status = $newStatus; // Đổi trạng thái đơn hàng thành 'pending_confirmation'
            } else {
                DB::rollBack();
                return redirect()->back()->withErrors([
                    'error' => 'Trạng thái đơn hàng không hợp lệ!'
                ]);
            }

            // Lưu cập nhật vào DB
            $order->save();

            // Gửi thông báo qua email cho người dùng khi trạng thái thay đổi
            $user = $order->user; // Giả sử quan hệ `user` được định nghĩa trong model `Order`
            Notification::create([
                'title' => 'Thông báo trạng thái đơn hàng',
                'description' => 'Đơn hàng #' . $order->id . ' đã được thay đổi trạng thái.',
                'url' => route('order.history', $order->id),
                'user_id' => $user->id,
            ]);
            // Gửi email
            Mail::to($user->email)->send(new OrderStatusUpdated($order, $newStatus));

            DB::commit();

            return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors([
                'error' => $e->getMessage(),
            ]);
        }
    }

}

