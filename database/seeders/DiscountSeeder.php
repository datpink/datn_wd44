<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DiscountSeeder extends Seeder
{
    /**
     * Chạy seeder để thêm dữ liệu mẫu vào bảng `discounts`.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('discounts')->insert([
            [
                'type' => 'percentage', // Loại giảm giá
                'discount_value' => 10.00, // Giá trị giảm giá 10%
                'start_date' => $now, // Ngày bắt đầu là hiện tại
                'end_date' => $now->addDays(7), // Ngày kết thúc sau 7 ngày
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'type' => 'fixed', // Loại giảm giá cố định
                'discount_value' => 50000.00, // Giá trị giảm giá 50000
                'start_date' => $now, // Ngày bắt đầu là hiện tại
                'end_date' => $now->addDays(10), // Ngày kết thúc sau 10 ngày
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'type' => 'percentage', // Loại giảm giá
                'discount_value' => 15.00, // Giá trị giảm giá 15%
                'start_date' => $now->subDays(5), // Ngày bắt đầu 5 ngày trước
                'end_date' => $now->addDays(5), // Ngày kết thúc sau 5 ngày
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
