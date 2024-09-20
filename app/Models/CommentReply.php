<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    use HasFactory;

    protected $table = 'post_coment_replies';
    protected $fillable = [
        'post_comment_id',
        'user_id',
        'reply'
    ];

    // Quan hệ với bảng comments
    public function comment()
    {
        return $this->belongsTo(Comment::class, 'post_comment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
