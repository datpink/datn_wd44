<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 
        'variant_name', 
        'sku', 
        'weight', 
        'dimension', // Đảm bảo cột này có trong $fillable
        'price', 
        'stock', 
        'image_url', 
        // 'description', 
        'status'
        ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class);
    }

    protected $casts = [
        'attributes' => 'array',
    ];
}
