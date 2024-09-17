<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostPart extends Model
{
    use HasFactory, SoftDeletes;
    public $timestamps = false;

    protected $fillable = [
        'type',
        'content',
        'image',
        'post_id',
        'order',
    ];

    public function post(){
        return $this->belongsTo(Post::class);
    }
}
