<?php

namespace App\Console\Commands;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoConfirmDelivered extends Command
{
        /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:auto-confirm-delivered';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically update order status to confirm_delivered after 3 days if not confirmed by the user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $threeDaysAgo = Carbon::now()->subDays(3);

        // Lấy các đơn hàng có trạng thái 'delivered' hơn 3 ngày mà chưa được xác nhận
        $orders = Order::where('status', 'delivered')
            ->where('updated_at', '<=', $threeDaysAgo)
            ->get();

        foreach ($orders as $order) {
            $order->status = 'confirm_delivered';
            $order->save();

            $this->info("Order ID {$order->id} status updated to confirm_delivered.");
        }

        $this->info("Completed processing orders for auto-confirmation.");
    }
}
