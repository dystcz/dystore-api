<?php

namespace Dystore\Api\Domain\Addresses\Http\Enums;

enum AddressType: string
{
    case BILLING = 'billing';
    case SHIPPING = 'shipping';
}
