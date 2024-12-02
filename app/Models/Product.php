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
        'quantity',
        'condition',
        'tomtat',
        'is_featured',
    ];

    // lấy tồn kho sản phẩm ra, ví dụ: $productStock = $product->calculateTotalStock();
    public function calculateTotalStock()
    {
        return $this->variants()->sum('stock');
    }

    // cập nhật lại tồn kho sản phẩm, ví dụ: $product->updateTotalStock() (nó tự cập nhật)
    public function updateTotalStock()
    {
        $this->stock = $this->calculateTotalStock();
        $this->save();
    }
    public function updateTotalStock2()
    {
        $totalStock = $this->stock = $this->calculateTotalStock();
        $this->save();
        return $totalStock;
    }
    // Product.php (Model)
    public function getDiscountPrice()
    {
        $price = $this->price; // Giá gốc của sản phẩm
        $discountAmount = 0; // Biến lưu giá trị giảm giá

        // Lấy danh sách các mã giảm giá liên quan đến danh mục của sản phẩm
        $discounts = $this->category->discounts;

        // Duyệt qua tất cả các mã giảm giá của danh mục
        foreach ($discounts as $discount) {
            if ($discount->type == 'fixed') {
                // Nếu là giảm giá cố định, trừ trực tiếp giá trị `value` vào giá gốc
                $discountAmount = $discount->value; // Set discountAmount là giá trị giảm
            } elseif ($discount->type == 'percentage') {
                // Nếu là giảm giá phần trăm, tính giá trị giảm theo tỷ lệ phần trăm
                $discountAmount = $price * ($discount->value / 100); // Tính giá trị giảm theo phần trăm
            }

            // Sau khi tính được discountAmount, thoát vòng lặp vì chúng ta chỉ lấy 1 mã giảm giá cho mỗi sản phẩm
            break;
        }

        // Tính giá sau giảm và gán vào trường discount_price
        $discountPrice = $price - $discountAmount;

        return $discountPrice; // Trả về giá sau khi giảm
    }
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
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
}
