<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'title', 'description', 'url', 'read_at'
    ];

    /**
     * Relationship với User: một thông báo thuộc về một người dùng.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Kiểm tra xem thông báo đã được đọc chưa.
     */
    public function isRead()
    {
        return $this->read_at !== null;
    }

}
