<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'Admin',
                'description' => 'Quản Trị Viên',
            ],
            [
                'id'          => 2,
                'name'        => 'User',
                'description' => 'Người Dùng',
            ],
            [
                'id' => 3,
                'name' => 'Staff',
                'description' => 'Nhân Viên',
            ],
        ]);
    }
}

