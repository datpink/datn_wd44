<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PostCommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post_comments')->insert([
            [
                'id' => 1,
                'post_id' => 1,
                'user_id' => 1,
                'content' => 'This is the first comment on the first post.',
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'post_id' => 1,
                'user_id' => 2,
                'content' => 'This is the second comment on the first post.',
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'post_id' => 2,
                'user_id' => 1,
                'content' => 'This is the first comment on the second post.',
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Add more comments as needed
        ]);
    }
}

