<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCommentReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_comment_id',
        'user_id',
        'reply'
    ];

    public function comment()
    {
        return $this->belongsTo(ProductComment::class, 'product_comment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
