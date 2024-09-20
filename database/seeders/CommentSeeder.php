<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Schema::disableForeignKeyConstraints();
        Comment::truncate();

        for ($i = 1; $i < 6; $i++) {
            Comment::create([
                'post_id' =>  $i,
                'user_id' =>  $i,
                'content' => 'content ' . $i,
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}
