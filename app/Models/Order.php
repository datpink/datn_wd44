<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'promotion_id',
        'total_amount',
        'discount_amount',
        'status',
        'payment_status',
        'shipping_address',
        'payment_method_id',
        'phone_number',
        'cancellation_reason',
        'refund_reason',
        'refund_images',
        'refund_method',
        'admin_status',
        'proof_image',
        'admin_message',
        'is_new'
    ];
    public function checkAndUpdatePendingOrders()
    {
        $pendingOrders = self::where('payment_status', 'pending')
            ->where('created_at', '<=', Carbon::now()->subMinutes(3))
            ->get();

        foreach ($pendingOrders as $order) {
            $order->update(['payment_status' => 'failed']);

            // Hoàn trả lại tồn kho
            foreach ($order->orderItems as $item) {
                if ($item->product_variant_id) {
                    $productVariant = ProductVariant::find($item->product_variant_id);
                    if ($productVariant) {
                        $productVariant->stock += $item->quantity;
                        $productVariant->save();
                    }
                } else {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->stock += $item->quantity;
                        $product->save();
                    }
                }
            }
        }
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function setStatusAttribute($value)
    {
        if (!in_array($value, OrderStatus::all())) {
            throw new \InvalidArgumentException("Invalid status value");
        }
        $this->attributes['status'] = $value;
    }

    public function getStatusAttribute($value)
    {
        return $value;
    }


    public function setPaymentStatusAttribute($value)
    {
        if (!in_array($value, PaymentStatus::all())) {
            throw new \InvalidArgumentException("Invalid payment status value");
        }
        $this->attributes['payment_status'] = $value;
    }

    public function getPaymentStatusAttribute($value)
    {
        return $value;
    }

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
