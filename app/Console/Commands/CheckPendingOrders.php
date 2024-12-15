<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Carbon\Carbon;
class CheckPendingOrders extends Command
{
    protected $signature = 'orders:check-pending';
    protected $description = 'Check and update pending orders to failed if more than 3 minutes have passed';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();
        $threeMinutesAgo = $now->subMinutes(3);

        // Lấy các đơn hàng đang có trạng thái 'pending' và tạo trước 3 phút
        $orders = Order::where('payment_status', 'pending')
            ->where('created_at', '<=', $threeMinutesAgo)
            ->get();

        // Cập nhật trạng thái và số lượng tồn kho
        foreach ($orders as $order) {
            $order->payment_status = 'payment_failed';
            $order->save();

            foreach ($order->orderItems as $item) {
                if ($item->product_variant_id) {
                    $variant = $item->productVariant;
                    $variant->stock += $item->quantity;
                    $variant->save();
                } else {
                    $product = $item->product;
                    $product->stock += $item->quantity;
                    $product->save();
                }
            }

            $this->info("Order ID {$order->id} đã được chuyển sang trạng thái 'failed'.");
        }

        $this->info('Đã kiểm tra và cập nhật trạng thái các đơn hàng pending.');
    }
}
