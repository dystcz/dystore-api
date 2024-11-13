<?php

namespace Dystore\Api\Domain\Orders\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\Orders\Contracts\CreatePaymentIntentController as CreatePaymentIntentControllerContract;
use Dystore\Api\Domain\Orders\JsonApi\V1\CreatePaymentIntentRequest;
use Dystore\Api\Domain\Orders\Models\Order;
use Dystore\Api\Domain\Payments\Actions\CreatePaymentIntent;
use LaravelJsonApi\Core\Responses\DataResponse;
use Lunar\Models\Contracts\Order as OrderContract;
use RuntimeException;

class CreatePaymentIntentController extends Controller implements CreatePaymentIntentControllerContract
{
    public function createPaymentIntent(
        CreatePaymentIntentRequest $request,
        OrderContract $order,
        CreatePaymentIntent $createPaymentIntent,
    ): DataResponse {
        /** @var Order $order */
        $this->authorize('update', $order);

        $paymentMethod = $request->validated('payment_method');
        $amount = $request->validated('amount') ?? null;
        $meta = $request->validated('meta') ?? [];

        try {
            $paymentIntent = $createPaymentIntent($paymentMethod, $order->cart, $meta, $amount);

            $order->update([
                'meta->payment_intent' => $paymentIntent->getId(),
            ]);
        } catch (RuntimeException $e) {
            return DataResponse::make($order)->withMeta([
                'payment_intent' => null,
            ]);
        }

        return DataResponse::make($order)
            ->withMeta([
                'payment_intent' => $paymentIntent->toArray(),
            ]);
    }
}
