<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductVariantsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('product_variants')->insert([
            [
                'product_id'        => 1,
                'variant_name'      => 'iPhone 13 Red',
                'price'             => 799.00,
                'stock'             => 10,
                'sku'               => 'SKU-IPH13-RED',
                'image_url'         => 'path/to/iphone13-red.jpg',
            ],
            [
                'product_id'        => 2,
                'variant_name'      => 'iPhone 13 Blue',
                'price'             => 799.00,
                'stock'             => 5,
                'sku'               => 'SKU-IPH13-BLUE',
                'image_url'         => 'path/to/iphone13-blue.jpg',
            ],
            [
                'product_id'        => 3,
                'variant_name'      => 'Samsung Galaxy S21 Black',
                'price'             => 999.00,
                'stock'             => 8,
                'sku'               => 'SKU-GALAXYS21-BLACK',
                'image_url'         => 'path/to/galaxys21-black.jpg',
            ],
        ]);
    }
}