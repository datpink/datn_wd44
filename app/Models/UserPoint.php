<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPoint extends Model
{
    use HasFactory;
    protected $table = 'user_points';

    // Các cột được phép ghi dữ liệu
    protected $fillable = [
        'user_id',
        'total_points',
    ];

    // Định nghĩa mối quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Định nghĩa mối quan hệ với UserPointTransaction
    public function transactions()
    {
        return $this->hasMany(UserPointTransaction::class);
    }

    // Tính tổng điểm đã tích lũy từ transactions
    public function getPointsEarnedAttribute()
    {
        return $this->transactions()->where('type', 'earn')->sum('points');
    }

    // Tính tổng điểm đã tiêu từ transactions
    public function getPointsRedeemedAttribute()
    {
        return $this->transactions()->where('type', 'redeem')->sum('points');
    }
}
