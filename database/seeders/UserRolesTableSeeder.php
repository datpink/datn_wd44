<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserRolesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('user_roles')->insert([
            [
                'user_id' => 1,  // ID của người dùng John Doe
                'role_id' => 1,  // Admin
            ],
            [
                'user_id' => 2,  // ID của người dùng Jane Smith
                'role_id' => 2,  // User
            ],
            [
                'user_id' => 3,  // ID của người dùng Alice Johnson
                'role_id' => 3,  // Staff
            ],
        ]);
    }
}
