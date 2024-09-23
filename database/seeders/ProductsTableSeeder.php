<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'catalogue_id'          => 1,
                'brand_id'              => 1,
                'name'                  => 'iPhone 13',
                'slug'                  => 'iphone-13',
                'sku'                   => 'SKU-IPH13',
                'description'  => 'Latest iPhone model with advanced features.',
                'image_url'             => 'path/to/iphone13.jpg',
                'price'                 => 799.00,
                'discount_price'        => 749.00,
                'stock'                 => 20,
                'weight'                => 0.174,
                'dimensions'            => '146.7 x 71.5 x 7.65 mm',
                'ratings_avg'           => 4.8,
                'ratings_count'         => 150,
                'is_active'             => true,
                'is_featured'           => true,
            ],
            [
                'catalogue_id'          => 1,
                'brand_id'              => 2,
                'name'                  => 'Samsung Galaxy S21',
                'slug'                  => 'samsung-galaxy-s21',
                'sku'                   => 'SKU-GALAXYS21',
                'description'  => 'Flagship smartphone with powerful performance.',
                'image_url'             => 'path/to/galaxys21.jpg',
                'price'                 => 999.00,
                'discount_price'        => null,
                'stock'                 => 15,
                'weight'                => 0.169,
                'dimensions'            => '151.7 x 71.2 x 7.9 mm',
                'ratings_avg'           => 4.5,
                'ratings_count'         => 200,
                'is_active'             => true,
                'is_featured'           => false,
            ],
            [
                'catalogue_id'          => 2,
                'brand_id'              => 4,
                'name'                  => 'Dell XPS 13',
                'slug'                  => 'dell-xps-13',
                'sku'                   => 'SKU-DELLXPS13',
                'description'  => 'High-performance laptop with sleek design.',
                'image_url'             => 'path/to/dellxps13.jpg',
                'price'                 => 1299.00,
                'discount_price'        => 1249.00,
                'stock'                 => 10,
                'weight'                => 1.2,
                'dimensions'            => '295 x 199 x 15.2 mm',
                'ratings_avg'           => 4.7,
                'ratings_count'         => 80,
                'is_active'             => true,
                'is_featured'           => true,
            ],
        ]);
    }
}
