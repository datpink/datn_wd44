<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_value',
        'status',
        'start_date',
        'end_date'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function userPromotions()
    {
        return $this->hasMany(UserPromotion::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_promotions');
    }
}
