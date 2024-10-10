<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use PHPUnit\Metadata\Uses;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [

                'name'          =>      'John Doe',
                'email'         =>      'john.doe@example.com',
                'password'      =>       Hash::make('password123'),
                'address'       =>      '123 Main St, Springfield',
                'phone'         =>      '+1234567890',
                'image'         =>      'path/to/image1.jpg',
            ],
            [
                'name'     => 'Jane Smith',
                'email'    => 'jane.smith@example.com',
                'password' => Hash::make('password456'),
                'address'  => '456 Elm St, Springfield',
                'phone'    => '+0987654321',
                'image'    => 'path/to/image2.jpg',
            ],
            [
                'name'          =>      'Alice Johnson',
                'email'         =>      'alice.johnson@example.com',
                'password'      =>      Hash::make('password789'),
                'address'       =>      '789 Oak St, Springfield',
                'phone'         =>      '+1122334455',
                'image'         =>      'path/to/image3.jpg',
            ],
        ]);
        $user = User::where('email', 'john.doe@example.com')->first(); // Tìm user bằng email
        $user->assignRole('admin'); // Gán vai trò admin cho user
    }
}
