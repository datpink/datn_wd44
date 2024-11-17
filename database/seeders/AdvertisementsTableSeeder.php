<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdvertisementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('advertisements')->insert([
            [
                'image' => 'path/to/image1.jpg',
                'title' => 'Quảng cáo 1',
                'description' => 'Mô tả cho quảng cáo 1',
                'button_text' => 'Xem thêm',
                'button_link' => 'http://127.0.0.1:8000',
                'position' => 1,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image' => 'path/to/image2.jpg',
                'title' => 'Quảng cáo 2',
                'description' => 'Mô tả cho quảng cáo 2',
                'button_text' => 'Tìm hiểu thêm',
                'button_link' => 'http://127.0.0.1:8000',
                'position' => 2,
                'status' => 'inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image' => 'path/to/image3.jpg',
                'title' => 'Quảng cáo 3',
                'description' => 'Mô tả cho quảng cáo 3',
                'button_text' => 'Đăng ký ngay',
                'button_link' => 'http://127.0.0.1:8000',
                'position' => 3,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image' => 'path/to/image4.jpg',
                'title' => 'Quảng cáo 4',
                'description' => 'Mô tả cho quảng cáo 4',
                'button_text' => 'Khám phá ngay',
                'button_link' => 'http://127.0.0.1:8000',
                'position' => 4,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image' => 'path/to/image5.jpg',
                'title' => 'Quảng cáo 5',
                'description' => 'Mô tả cho quảng cáo 5',
                'button_text' => 'Mua ngay',
                'button_link' => 'http://127.0.0.1:8000',
                'position' => 5,
                'status' => 'inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}