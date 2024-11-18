<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'txn_ref',
        'order_info',
        'amount',
        'status',
        'vnp_response_code'
    ];

    /**
     * Một giao dịch thuộc về một đơn hàng
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
