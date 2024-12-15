<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPointTransaction extends Model
{
    use HasFactory;
    // Tên bảng
    protected $table = 'user_point_transactions';

    // Các cột được phép ghi dữ liệu
    protected $fillable = [
        'user_point_id',
        'type',
        'points',
        'description',
        'order_id',
    ];

    // Định nghĩa mối quan hệ với UserPoint
    public function userPoint()
    {
        return $this->belongsTo(UserPoint::class);
    }
}
