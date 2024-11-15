<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact; // Đảm bảo bạn đã có model Contact
use Faker\Factory as Faker;

class ContactSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Tạo 50 liên hệ giả
        foreach (range(1, 10) as $index) {
            Contact::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'message' => $faker->paragraph,
                'reply' => null, // Bạn có thể để null hoặc thêm nội dung mẫu
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}