<?php

namespace Dystore\Api\Domain\Payments\Enums;

enum PaymentIntentStatus: string
{
    case INTENT = 'intent';
    case SUCCEEDED = 'succeeded';
}
