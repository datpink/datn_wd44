<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeValueTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('attribute_values')->insert([
            ['name' => 'Red'    ,    'attribute_id' => 1],
            ['name' => 'Blue'   ,    'attribute_id' => 1],
            ['name' => 'Small'  ,    'attribute_id' => 2],
            ['name' => 'Medium' ,    'attribute_id' => 2],
            ['name' => '256GB'  ,    'attribute_id' => 3],
            ['name' => '512GB'  ,    'attribute_id' => 3],
        ]);
    }
}