<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable = ['name', 'region_id'];

    // Quan hệ với bảng Region: Mỗi thành phố thuộc về một vùng miền
    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
