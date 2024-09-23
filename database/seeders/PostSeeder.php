<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run()
    {
        // Lấy tất cả các danh mục
        $categories = Category::all();

        // Kiểm tra xem có danh mục nào không
        if ($categories->isEmpty()) {
            $this->command->info('Không có danh mục nào. Hãy tạo danh mục trước khi chạy seeder cho bài viết.');
            return;
        }

        // Tạo 10 bài viết mẫu
        for ($i = 1; $i <= 10; $i++) {
            Post::create([
                'title' => 'Bài viết mẫu ' . $i,
                'tomtat' => 'Đây là tóm tắt cho bài viết mẫu ' . $i,
                'content' => 'Nội dung chi tiết cho bài viết mẫu ' . $i . '. Đây là nơi bạn có thể thêm nội dung bài viết.',
                'image' => 'image' . $i . '.jpg', // Giả sử bạn có các hình ảnh như image1.jpg, image2.jpg,...
                'category_id' => $categories->random()->id, // Chọn ngẫu nhiên một danh mục
                'user_id' => 1, // Giả sử ID người dùng là 1
                'slug' => Str::slug('Bài viết mẫu ' . $i),
                'is_featured' => $i % 2 === 0, // Đánh dấu bài viết chéo cho bài viết nổi bật
            ]);
        }

        $this->command->info('Đã tạo 10 bài viết mẫu.');
    }
}
