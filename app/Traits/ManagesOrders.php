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

            // Nếu trạng thái hiện tại là "Delivering" và trạng thái mới là "processing", từ chối cập nhật
            if ($currentStatus === 'Delivering' && $newStatus === 'processing') {
                DB::rollBack();
                return redirect()->back()->withErrors([
                    'error' => 'Không thể chuyển từ trạng thái Đang giao hàng về trạng thái Đang xử lý!'
                ]);
            }

            // Cập nhật trạng thái đơn hàng
            $order->status = $newStatus;

            // Cập nhật trạng thái thanh toán nếu cần
            if ($newStatus === 'shipped') {
                $order->payment_status = 'paid';
            } elseif (in_array($newStatus, ['canceled', 'refunded'])) {
                $order->payment_status = 'pending';
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

