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
        'price',
        'weight',
        'dimension',
        'stock',
        'sku',
        'image_url',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_variant_attributes', 'product_variant_id', 'attribute_value_id');
    }
}
