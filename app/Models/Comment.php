<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='post_comments';

    protected $fillable = [
        'post_id',
        'user_id',
        'content'
    ];
   // Quan hệ với phản hồi
   public function commentReplys()
   {
       return $this->hasMany(CommentReply::class, 'post_comment_id')->withTrashed();
   }
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
