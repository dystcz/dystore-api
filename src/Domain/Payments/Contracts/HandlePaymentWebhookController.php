<?php

namespace Dystore\Api\Domain\Payments\Contracts;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @see \Dystore\Api\Domain\Payments\Http\Controllers\HandlePaymentWebhookController
 */
interface HandlePaymentWebhookController
{
    public function __invoke(string $paymentDriver, Request $request): JsonResponse;
}
