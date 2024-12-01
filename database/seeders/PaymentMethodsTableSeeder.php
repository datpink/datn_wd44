<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('payment_methods')->insert([
            [
                'id'            => 1,
                'name'          => 'vnpay',
                'description'   => 'Thanh toán với VNPay',
            ],
            [
                'id'            => 2,
                'name'          => 'code',
                'description'   => 'Thanh toán khi nhận hàng',
            ]
        ]);
    }
}
