<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'review_id',
        'response',
        'responder_id'
    ];

    public function review()
    {
        return $this->belongsTo(ProductReview::class);
    }

    public function responder()
    {
        return $this->belongsTo(User::class, 'responder_id');
    }
}
