<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CataloguesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('catalogues')->insert([
            [
                'name'          => 'Điện thoại',
                'slug'          => 'dien-thoai',
                'image'         => 'path/to/phones.jpg',
                'description'   => 'Danh mục điện thoại',
                'status'        => 'active',
                'parent_id'     => null,
            ],
            [
                'name'          => 'Smartphones',
                'slug'          => 'smartphones',
                'image'         => 'path/to/smartphones.jpg',
                'description'   => 'Điện thoại thông minh',
                'status'        => 'active',
                'parent_id'     => 1,
            ],
            [
                'name'          => 'Feature Phones',
                'slug'          => 'feature-phones',
                'image'         => 'path/to/feature-phones.jpg',
                'description'   => 'Điện thoại cơ bản',
                'status'        => 'inactive',
                'parent_id'     => 1,
            ],
            [
                'name'          => 'Laptop',
                'slug'          => 'laptop',
                'image'         => 'path/to/laptop.jpg',
                'description'   => 'Danh mục laptop',
                'status'        => 'active',
                'parent_id'     => null,
            ],
            [
                'name'          => 'Gaming Laptops',
                'slug'          => 'gaming-laptops',
                'image'         => 'path/to/gaming-laptops.jpg',
                'description'   => 'Laptop chơi game',
                'status'        => 'active',
                'parent_id'     => 4, // ID của danh mục cha
            ],
            [
                'name'          => 'Ultrabooks',
                'slug'          => 'ultrabooks',
                'image'         => 'path/to/ultrabooks.jpg',
                'description'   => 'Laptop siêu mỏng',
                'status'        => 'inactive',
                'parent_id'     => 4,
            ],
        ]);
    }
}