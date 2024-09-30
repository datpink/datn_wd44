<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('order_items')->insert([
            [
                'order_id' => 19,
                'product_variant_id' => 1,
                'quantity' => 2,
                'price' => 799.00,
                'total' => 1598.00,
            ],
            [
                'order_id' => 20,
                'product_variant_id' => 3,
                'quantity' => 1,
                'price' => 1299.00,
                'total' => 1299.00,
            ],
            [
                'order_id' => 21,
                'product_variant_id' => 2,
                'quantity' => 3,
                'price' => 999.00,
                'total' => 2997.00,
            ],
        ]);
    }
}
