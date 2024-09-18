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
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
                'id'          => 1,
                'name'        => 'Admin',
=======
=======
>>>>>>> 600b967 (oai-commit-update-users)
                'id' => 1,
                'name' => 'Admin',
>>>>>>> fc47897 (oai-commit-update)
                'description' => 'Quản Trị Viên',
            ],
            [
                'id' => 2,
                'name' => 'User',
                'description' => 'Người Dùng',
            ],
            [
                'id' => 3,
                'name' => 'Staff',
=======
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
>>>>>>> 48b050e (oai-commit-update-users)
                'description' => 'Nhân Viên',
=======
                'id'            => 1,
                'name'          => 'Admin',
                'description'   => 'Quản Trị Viên',
=======
                'id'          => 1,
                'name'        => 'Admin',
                'description' => 'Quản Trị Viên',
>>>>>>> 718cb74 (oai-commit-update-users)
            ],
            [
                'id'          => 2,
                'name'        => 'User',
                'description' => 'Người Dùng',
            ],
            [
<<<<<<< HEAD
                'id'            => 3,
                'name'          => 'Staff',
                'description'   => 'Nhân Viên',
>>>>>>> 3235956 (oai-commit-update)
=======
                'id'          => 3,
                'name'        => 'Staff',
                'description' => 'Nhân Viên',
>>>>>>> 718cb74 (oai-commit-update-users)
            ],
        ]);
    }
}

