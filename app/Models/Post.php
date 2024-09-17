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
        'summary',
        'category_id',
        'user_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function parts()
    {
        return $this->hasMany(PostPart::class);
    }

    protected static function booted()
    {
        static::deleting(function ($post) {
            if ($post->isForceDeleting()) {
                $post->parts()->forceDelete();
            } else {
                $post->parts()->delete();
            }
        });

        static::restoring(function ($post) {
            $post->parts()->withTrashed()->restore();
        });
    }
}
