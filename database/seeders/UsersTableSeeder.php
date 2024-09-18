<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 718cb74 (oai-commit-update-users)
                'name'     => 'John Doe',
                'email'    => 'john.doe@example.com',
                'password' => Hash::make('password123'),
                'address'  => '123 Main St, Springfield',
                'phone'    => '+1234567890',
                'image'    => 'path/to/image1.jpg',
<<<<<<< HEAD
=======
=======
>>>>>>> 600b967 (oai-commit-update-users)
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'password' => Hash::make('password123'),
                'address' => '123 Main St, Springfield',
                'phone' => '+1234567890',
                'image' => 'path/to/image1.jpg',
                'role_id' => 1,
>>>>>>> fc47897 (oai-commit-update)
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'password' => Hash::make('password456'),
                'address' => '456 Elm St, Springfield',
                'phone' => '+0987654321',
                'image' => 'path/to/image2.jpg',
                'role_id' => 2,
            ],
            [
                'name' => 'Alice Johnson',
                'email' => 'alice.johnson@example.com',
                'password' => Hash::make('password789'),
<<<<<<< HEAD
                'address'  => '789 Oak St, Springfield',
                'phone'    => '+1122334455',
                'image'    => 'path/to/image3.jpg',
=======
                'name'          =>      'John Doe',
                'email'         =>      'john.doe@example.com',
                'password'      =>       Hash::make('password123'),
                'address'       =>      '123 Main St, Springfield',
                'phone'         =>      '+1234567890',
                'image'         =>      'path/to/image1.jpg',
                'role_id'       =>      1,
=======
>>>>>>> 718cb74 (oai-commit-update-users)
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
<<<<<<< HEAD
                'name'          =>      'Alice Johnson',
                'email'         =>      'alice.johnson@example.com',
                'password'      =>      Hash::make('password789'),
                'address'       =>      '789 Oak St, Springfield',
                'phone'         =>      '+1122334455',
                'image'         =>      'path/to/image3.jpg',
                'role_id'       =>      3,
>>>>>>> 3235956 (oai-commit-update)
=======
                'name'     => 'Alice Johnson',
                'email'    => 'alice.johnson@example.com',
                'password' => Hash::make('password789'),
                'address'  => '789 Oak St, Springfield',
                'phone'    => '+1122334455',
                'image'    => 'path/to/image3.jpg',
>>>>>>> 718cb74 (oai-commit-update-users)
=======
                'address' => '789 Oak St, Springfield',
                'phone' => '+1122334455',
                'image' => 'path/to/image3.jpg',
                'role_id' => 3,
<<<<<<< HEAD
>>>>>>> fc47897 (oai-commit-update)
=======
=======
                'name'     => 'John Doe',
                'email'    => 'john.doe@example.com',
                'password' => Hash::make('password123'),
                'address'  => '123 Main St, Springfield',
                'phone'    => '+1234567890',
                'image'    => 'path/to/image1.jpg',
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
                'name'     => 'Alice Johnson',
                'email'    => 'alice.johnson@example.com',
                'password' => Hash::make('password789'),
                'address'  => '789 Oak St, Springfield',
                'phone'    => '+1122334455',
                'image'    => 'path/to/image3.jpg',
>>>>>>> 48b050e (oai-commit-update-users)
>>>>>>> 600b967 (oai-commit-update-users)
            ],
        ]);
    }
}
