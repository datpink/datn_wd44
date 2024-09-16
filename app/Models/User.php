<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'phone',
        'image',
        'role_id'
    ];

    /**
     * Mối quan hệ với model Role.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Mối quan hệ với model Order.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Mối quan hệ với model Post.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Mối quan hệ với model Comment.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Kiểm tra vai trò của người dùng.
     *
     * @param mixed $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->role->id == $role; // Kiểm tra vai trò dựa trên id
    }
}