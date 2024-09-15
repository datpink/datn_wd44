<?php

namespace App\Enums;

class OrderStatus
{
    const PROCESSING = 'processing';
    const DELIVERING = 'Delivering';
    const SHIPPED = 'shipped';
    const CANCELED = 'canceled';
    const REFUNDED = 'refunded';

    public static function all()
    {
        return [
            self::PROCESSING,
            self::DELIVERING,
            self::SHIPPED,
            self::CANCELED,
            self::REFUNDED,
        ];
    }
}