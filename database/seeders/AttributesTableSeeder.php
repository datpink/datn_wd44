<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('attributes')->insert([
            ['name' => 'Color'],
            ['name' => 'Size'],
            ['name' => 'Storage'],
        ]);
    }
}