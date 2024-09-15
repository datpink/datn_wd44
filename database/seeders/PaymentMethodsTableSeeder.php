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
                'id' => 1,
                'name' => 'Credit Card',
                'description' => 'Payment via credit card.',
            ],
            [
                'id' => 2,
                'name' => 'PayPal',
                'description' => 'Payment via PayPal.',
            ],
            [
                'id' => 3,
                'name' => 'Bank Transfer',
                'description' => 'Payment via bank transfer.',
            ],
            [
                'id' => 4,
                'name' => 'Cash on Delivery',
                'description' => 'Payment in cash upon delivery.',
            ],
        ]);
    }
}
