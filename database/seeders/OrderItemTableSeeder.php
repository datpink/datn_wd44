<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemTableSeeder extends Seeder
{
    public function run()
    {
        $orderItems = [
            [
                'order_id' => 1,
                'product_variant_id' => 1,
                'quantity' => 2,
                'price' => 799.00,
                'total' => 1598.00,
            ],
            [
                'order_id' => 2,
                'product_variant_id' => 3,
                'quantity' => 1,
                'price' => 1299.00,
                'total' => 1299.00,
            ],
            [
                'order_id' => 3,
                'product_variant_id' => 2,
                'quantity' => 3,
                'price' => 999.00,
                'total' => 2997.00,
            ],
            [
                'order_id' => 4,
                'product_variant_id' => 1,
                'quantity' => 1,
                'price' => 799.00,
                'total' => 799.00,
            ],
            [
                'order_id' => 5,
                'product_variant_id' => 2,
                'quantity' => 2,
                'price' => 999.00,
                'total' => 1998.00,
            ],
            [
                'order_id' => 6,
                'product_variant_id' => 3,
                'quantity' => 1,
                'price' => 1299.00,
                'total' => 1299.00,
            ],
            [
                'order_id' => 7,
                'product_variant_id' => 1,
                'quantity' => 3,
                'price' => 799.00,
                'total' => 2397.00,
            ],
            [
                'order_id' => 8,
                'product_variant_id' => 2,
                'quantity' => 4,
                'price' => 999.00,
                'total' => 3996.00,
            ],
            [
                'order_id' => 9,
                'product_variant_id' => 3,
                'quantity' => 1,
                'price' => 1299.00,
                'total' => 1299.00,
            ],
            [
                'order_id' => 10,
                'product_variant_id' => 1,
                'quantity' => 2,
                'price' => 799.00,
                'total' => 1598.00,
            ],
        ];

        DB::table('order_items')->insert($orderItems);
    }
}
