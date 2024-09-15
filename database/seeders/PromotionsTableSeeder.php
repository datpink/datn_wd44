<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromotionsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('promotions')->insert([
            [
                'id' => 1,
                'code' => 'SUMMER21',
                'discount_value' => 20.00,
                'status' => 'active',
                'start_date' => '2024-06-01',
                'end_date' => '2024-08-31',
            ],
            [
                'id' => 2,
                'code' => 'WINTER21',
                'discount_value' => 15.00,
                'status' => 'inactive',
                'start_date' => '2024-12-01',
                'end_date' => '2024-12-31',
            ],
            [
                'id' => 3,
                'code' => 'BLACKFRIDAY',
                'discount_value' => 30.00,
                'status' => 'active',
                'start_date' => '2024-11-25',
                'end_date' => '2024-11-30',
            ],
            [
                'id' => 4,
                'code' => 'NEWYEAR2025',
                'discount_value' => 10.00,
                'status' => 'active',
                'start_date' => '2024-12-31',
                'end_date' => '2025-01-31',
            ],
        ]);
    }
}

