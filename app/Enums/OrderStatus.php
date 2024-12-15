<?php

namespace App\Enums;

class OrderStatus
{
    const pending_confirmation = 'pending_confirmation';
    const pending_pickup = 'pending_pickup';
    const pending_delivery = 'pending_delivery';
    const refunded = 'returned';
    const delivered = 'delivered';
    const canceled = 'canceled';
    const confirm_delivered = 'confirm_delivered';

    public static function all()
    {
        return [
            self::pending_confirmation,
            self::pending_pickup,
            self::pending_delivery,
            self::refunded,
            self::delivered,
            self::canceled,
            self::confirm_delivered,
        ];
    }
}