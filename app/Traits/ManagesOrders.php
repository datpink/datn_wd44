<?php

namespace App\Traits;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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


            // Cập nhật trạng thái đơn hàng
            $order->status = $newStatus;

            // Cập nhật trạng thái thanh toán nếu cần
            if ($newStatus === 'delivered') {
                $order->payment_status = 'paid'; // Đã thanh toán
            } elseif (in_array($newStatus, ['canceled', 'returned'])) {
                $order->payment_status = 'refunded'; // Hoàn trả
            } elseif ($newStatus === 'pending_confirmation') {
                $order->payment_status = 'unpaid'; // Chưa thanh toán
            }


            $order->save();

            DB::commit();

            return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors([
                'error' => 'Đã xảy ra lỗi khi cập nhật đơn hàng. Vui lòng thử lại!'
            ]);
        }
    }


}

