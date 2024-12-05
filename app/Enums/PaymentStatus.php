<?php

namespace App\Enums;

class PaymentStatus
{
    const unpaid = 'unpaid';
    const paid = 'paid';
    const refunded = 'refunded';
    const payment_failed = 'payment_failed';

    public static function all()
    {
        return [
            self::unpaid,
            self::paid,
            self::refunded,
            self::payment_failed,
        ];
    }
}