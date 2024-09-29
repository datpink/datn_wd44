<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'image',
        'title',
        'description',
        'button_text',
        'button_link',
        'status',
    ];

    // Tùy chọn để sử dụng soft deletes
    protected $dates = ['deleted_at'];
}
