<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Banner::create([
            'image' => 'banners/banner1.jpg',
            'title' => 'Black Friday Sale',
            'description' => 'Amazing Black Friday Deals on Electronics',
            'button_text' => 'Shop Now',
            'button_link' => 'http://127.0.0.1:8000',
            'status' => 'active', // Đảm bảo 'active' là chuỗi
        ]);

        Banner::create([
            'image' => 'banners/banner2.jpg',
            'title' => 'Summer Collection 50% Off',
            'description' => 'Get the latest summer trends at half the price!',
            'button_text' => 'Discover More',
            'button_link' => 'http://127.0.0.1:8000',
            'status' => 'active', // Đảm bảo 'active' là chuỗi
        ]);

        Banner::create([
            'image' => 'banners/banner3.jpg',
            'title' => 'New Arrivals',
            'description' => 'Check out the latest fashion and gadgets!',
            'button_text' => 'Browse Now',
            'button_link' => 'http://127.0.0.1:8000',
            'status' => 'inactive', // Đảm bảo 'inactive' là chuỗi
        ]);
    }
}


