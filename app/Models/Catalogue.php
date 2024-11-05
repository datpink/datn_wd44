<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Catalogue extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'image',
        'description',
        'status',
        'slug',
        'parent_id',
        'deleted_at'
    ];

    public function parent()
    {
        return $this->belongsTo(Catalogue::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Catalogue::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeByLevel($query, $level)
    {
        if ($level == 0) {
            return $query->whereNull('parent_id');
        } elseif ($level == 1) {
            return $query->where('parent_id', '!=', null);
        } else {
            // Xử lý các cấp độ tiếp theo nếu cần
            return $query->where('parent_id', '!=', null)
                ->whereHas('parent', function ($q) use ($level) {
                    $q->where('parent_id', '!=', null);
                });
        }
    }
}
