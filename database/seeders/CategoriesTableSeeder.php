<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'Điện thoại',
                'description' => 'Danh mục các loại điện thoại thông minh',
                'status' => 'active',
                'parent_id' => null, // Đây là danh mục cấp cao nhất
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Máy tính xách tay',
                'description' => 'Danh mục các loại máy tính xách tay',
                'status' => 'active',
                'parent_id' => null, // Đây là danh mục cấp cao nhất
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Phụ kiện điện thoại',
                'description' => 'Danh mục các phụ kiện cho điện thoại',
                'status' => 'active',
                'parent_id' => 1, // Đây là danh mục con của "Điện thoại"
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Phụ kiện máy tính',
                'description' => 'Danh mục các phụ kiện cho máy tính',
                'status' => 'active',
                'parent_id' => 2, // Đây là danh mục con của "Máy tính xách tay"
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}