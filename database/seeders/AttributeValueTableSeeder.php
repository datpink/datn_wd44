<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeValueTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('attribute_values')->insert([
            // Colors
            ['name' => 'Red'    , 'attribute_id' => 1],
            ['name' => 'Blue'   , 'attribute_id' => 1],
            ['name' => 'Green'  , 'attribute_id' => 1],
            ['name' => 'Yellow' , 'attribute_id' => 1],
            ['name' => 'Black'  , 'attribute_id' => 1],
            ['name' => 'White'  , 'attribute_id' => 1],
            ['name' => 'Purple' , 'attribute_id' => 1],
            ['name' => 'Orange' , 'attribute_id' => 1],
            ['name' => 'Pink'   , 'attribute_id' => 1],
            ['name' => 'Brown'  , 'attribute_id' => 1],
            ['name' => 'Gray'   , 'attribute_id' => 1],
            ['name' => 'Cyan'   , 'attribute_id' => 1],

            // Sizes
            ['name' => 'Small'  , 'attribute_id' => 2],
            ['name' => 'Medium' , 'attribute_id' => 2],
            ['name' => 'Large'  , 'attribute_id' => 2],

            // Storage
            ['name' => '16GB'   , 'attribute_id' => 3],
            ['name' => '32GB'   , 'attribute_id' => 3],
            ['name' => '64GB'   , 'attribute_id' => 3],
            ['name' => '128GB'  , 'attribute_id' => 3],
            ['name' => '256GB'  , 'attribute_id' => 3],
            ['name' => '512GB'  , 'attribute_id' => 3],
            ['name' => '1TB'    , 'attribute_id' => 3],
        ]);
    }
}