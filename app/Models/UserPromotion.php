<?php

// app/Models/UserPromotion.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPromotion extends Model
{
    use HasFactory;

    // Tên bảng
    protected $table = 'user_promotions';

    // Các trường có thể gán giá trị (mass assignable)
    protected $fillable = [
        'user_id',
        'promotion_id',
    ];

    // Quan hệ với bảng users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với bảng promotions
    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
    
}
