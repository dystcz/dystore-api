<?php

namespace Dystore\Api\Tests\Stubs\Payments\PaymentAdapters;

use Dystore\Api\Domain\Payments\Contracts\PaymentIntent as PaymentIntentContract;
use Dystore\Api\Domain\Payments\Data\PaymentIntent;
use Dystore\Api\Domain\Payments\Enums\PaymentIntentStatus;
use Dystore\Api\Domain\Payments\PaymentAdapters\PaymentAdapter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lunar\Models\Contracts\Cart as CartContract;

class TestPaymentAdapter extends PaymentAdapter
{
    public function createIntent(CartContract $cart, array $meta = [], ?int $amount = null): PaymentIntentContract
    {
        $intent = [
            'id' => 1,
            'amount' => 500,
            'status' => PaymentIntentStatus::INTENT->value,
        ];

        $paymentIntent = new PaymentIntent((object) $intent);

        $this->createIntentTransaction($cart, $paymentIntent);

        return $paymentIntent;
    }

    public function handleWebhook(Request $request): JsonResponse
    {
        return new JsonResponse(null, 200);
    }

    public function getDriver(): string
    {
        return 'test';
    }

    public function getType(): string
    {
        return 'test';
    }
}
