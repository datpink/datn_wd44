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
                'id'                => 1,
                'code'              => 'SUMMER21',
                'discount_value'    => 20.00,
                'status'            => 'active',
                'start_date'        => '2024-06-01',
                'end_date'          => '2024-08-31',
                'type'              => 'percentage', // Giảm theo %
                'applies_to_order'  => true,  // Áp dụng cho đơn hàng
                'applies_to_shipping' => false, // Không áp dụng cho phí vận chuyển
                'min_order_value'   => 100.00,  // Mức tối thiểu để áp dụng mã giảm giá cho đơn hàng
            ],
            [
                'id'                => 2,
                'code'              => 'WINTER21',
                'discount_value'    => 15.00,
                'status'            => 'inactive',
                'start_date'        => '2024-12-01',
                'end_date'          => '2024-12-31',
                'type'              => 'fixed_amount', // Giảm giá tiền cố định
                'applies_to_order'  => true,  // Áp dụng cho đơn hàng
                'applies_to_shipping' => true, // Áp dụng cho phí vận chuyển
                'min_order_value'   => 50.00,  // Mức tối thiểu để áp dụng mã giảm giá cho đơn hàng
            ],
            [
                'id'                => 3,
                'code'              => 'BLACKFRIDAY',
                'discount_value'    => 30.00,
                'status'            => 'active',
                'start_date'        => '2024-11-25',
                'end_date'          => '2024-11-30',
                'type'              => 'percentage', // Giảm theo %
                'applies_to_order'  => false, // Không áp dụng cho đơn hàng
                'applies_to_shipping' => true, // Áp dụng cho phí vận chuyển
                'min_order_value'   => null, // Không áp dụng mức tối thiểu cho mã này
            ],
            [
                'id'                => 4,
                'code'              => 'NEWYEAR2025',
                'discount_value'    => 10.00,
                'status'            => 'active',
                'start_date'        => '2024-12-31',
                'end_date'          => '2025-01-31',
                'type'              => 'free_shipping', // Free shipping
                'applies_to_order'  => false, // Không áp dụng cho đơn hàng
                'applies_to_shipping' => true, // Áp dụng cho phí vận chuyển
                'min_order_value'   => null, // Không áp dụng mức tối thiểu cho mã này
            ],
        ]);
        
    }
}
