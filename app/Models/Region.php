<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    // Quan hệ với bảng City: Một vùng miền có nhiều thành phố
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
