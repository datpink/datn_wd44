<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductVariantAttributesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('product_variant_attributes')->insert([
            [
                'product_variant_id' => 10,
                'attribute_value_id' => 1,
            ],
            [
                'product_variant_id' => 11,
                'attribute_value_id' => 3,
            ],
            [
                'product_variant_id' => 12,
                'attribute_value_id' => 2,
            ],
        ]);
    }
}