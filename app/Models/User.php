<?php

namespace App\Models;

use App\Models\Promotion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'phone',
        'image',
        'status',
        'google_id',
        'facebook_id',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function isAdmin(): bool
    {
        return $this->roles()->where('name', 'admin')->exists(); // Kiểm tra xem người dùng có vai trò admin không
    }
    public function promotions()
{
    return $this->belongsToMany(Promotion::class, 'user_promotions')
                ->withPivot('is_used')
                ->withTimestamps();
}
}
