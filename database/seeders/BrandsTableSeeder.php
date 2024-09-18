<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('brands')->insert([
            [
                'name'        => 'Apple',
                'description' => 'Company known for iPhones, iPads, and MacBooks.',
            ],
            [
                'name'        => 'Samsung',
                'description' => 'Leading manufacturer of smartphones and electronics.',
            ],
            [
                'name'        => 'Sony',
                'description' => 'Known for electronics, gaming, and entertainment.',
            ],
            [
                'name'        => 'Dell',
                'description' => 'Manufacturer of personal computers and laptops.',
            ],
            [
                'name'        => 'HP',
                'description' => 'Provider of computing and printing solutions.',
            ],
        ]);
    }
}
