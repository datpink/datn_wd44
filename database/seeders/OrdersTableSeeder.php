<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;

class OrdersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('orders')->insert([
            [
                'user_id'           => 1,
                'promotion_id'      => 1,
                'total_amount'      => 100.00,
                'discount_amount'   => 20.00,
                'status'            => OrderStatus::SHIPPED,
                'payment_status'    => PaymentStatus::PENDING,
                'shipping_address'  => '123 Main St, Anytown, USA',
                'payment_method_id' => 1,
                'phone_number'      => '0123456789',
            ],
            [
                'user_id'           => 2,
                'promotion_id'      => 2,
                'total_amount'      => 200.00,
                'discount_amount'   => 30.00,
                'status'            => OrderStatus::PROCESSING,
                'payment_status'    => PaymentStatus::PAID,
                'shipping_address'  => '456 Elm St, Othertown, USA',
                'payment_method_id' => 2,
                'phone_number'      => '0987654321',
            ],
            [
                'user_id'           => 3,
                'promotion_id'      => 3,
                'total_amount'      => 150.00,
                'discount_amount'   => 15.00,
                'status'            => OrderStatus::DELIVERING,
                'payment_status'    => PaymentStatus::PENDING,
                'shipping_address'  => '789 Pine St, Newtown, USA',
                'payment_method_id' => 1,
                'phone_number'      => '0112233445',
            ],
        ]);
    }
}
