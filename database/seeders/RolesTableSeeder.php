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
<<<<<<< HEAD
                'id'          => 1,
                'name'        => 'Admin',
                'description' => 'Quản Trị Viên',
            ],
            [
                'id'          => 2,
                'name'        => 'User',
                'description' => 'Người Dùng',
            ],
            [
                'id'          => 3,
                'name'        => 'Staff',
                'description' => 'Nhân Viên',
=======
                'id'            => 1,
                'name'          => 'Admin',
                'description'   => 'Quản Trị Viên',
            ],
            [
                'id'            => 2,
                'name'          => 'User',
                'description'   => 'Người Dùng',
            ],
            [
                'id'            => 3,
                'name'          => 'Staff',
                'description'   => 'Nhân Viên',
>>>>>>> 3235956 (oai-commit-update)
            ],
        ]);
    }
}

