<?php

namespace Dystore\Api\Domain\Orders\Enums;

use Dystore\Api\Domain\Orders\Contracts\OrderStatusContract;

enum OrderStatus: string implements OrderStatusContract
{
    case AWAITING_PAYMENT = 'awaiting-payment';
    case PENDING_PAYMENT = 'pending-payment';
    case PAYMENT_RECEIVED = 'payment-received';
    case MANUFACTURING = 'manufacturing';
    case DISPATCHED = 'dispatched';
    case DELIVERED = 'delivered';
    case ON_HOLD = 'on-hold';
}
