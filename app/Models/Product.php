<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'catalogue_id',
        'name',
        'slug',
        'sku',
        'description',
        'image_url',
        'price',
        'discount_price',
        'discount_percentage',
        'stock',
        'weight',
        'dimensions',
        'brand_id',
        'ratings_avg',
        'ratings_count',
        'is_active',
        'condition',
        'tomtat',
        'is_featured'
    ];

    public function catalogue()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function comments()
    {
        return $this->hasMany(ProductComment::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }
}
