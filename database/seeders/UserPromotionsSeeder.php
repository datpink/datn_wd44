<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserPromotionsSeeder extends Seeder
{
    public function run()
    {
        DB::table('user_promotions')->insert([
            [
                'user_id'       => 1,
                'promotion_id'  => 1,
                'is_used'       => false,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'user_id'       => 2,
                'promotion_id'  => 2,
                'is_used'       => false,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            // Thêm dữ liệu mẫu khác nếu cần
        ]);
    }
}
