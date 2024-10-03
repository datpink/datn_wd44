<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $products = [];
        $catalogueIds = range(1, 5); // Giả sử có 5 catalogue
        $brandIds = range(1, 5); // Giả sử có 5 brand

        for ($i = 1; $i <= 15; $i++) {
            $products[] = [
                'catalogue_id' => $catalogueIds[array_rand($catalogueIds)],
                'brand_id' => $brandIds[array_rand($brandIds)],
                'name' => 'Product ' . $i,
                'slug' => Str::slug('Product ' . $i),
                'sku' => 'SKU' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'description' => 'Description for Product ' . $i,
                'image_url' => 'assets/images/product' . $i . '.jpg', // Thay đổi thành URL hình ảnh thực tế
                'price' => rand(1000, 10000),
                'discount_price' => rand(500, 9999),
                'discount_percentage' => rand(0, 30),
                'stock' => rand(0, 100),
                'weight' => rand(1, 10),
                'dimensions' => rand(10, 50) . 'x' . rand(10, 50) . 'x' . rand(10, 50),
                'ratings_avg' => rand(1, 5),
                'ratings_count' => rand(0, 100),
                'is_active' => true,
                'is_featured' => $i % 3 === 0, // Mỗi 3 sản phẩm sẽ là nổi bật
                'condition' => ['new', 'used', 'refurbished'][array_rand(['new', 'used', 'refurbished'])],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('products')->insert($products);
    }
}
