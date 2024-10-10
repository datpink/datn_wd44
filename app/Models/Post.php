<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'tomtat',  // Tóm tắt
        'content', // Nội dung
        'image',   // Đường dẫn ảnh
        'category_id',
        'user_id',
        'slug',
    ];

    /**
     * Quan hệ với bảng Category
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Tạo slug cho bài viết trước khi lưu
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->slug = \Str::slug($post->title);
        });
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

}

