<?php

namespace Dystore\Api\Domain\Payments\Actions;

use Dystore\Api\Domain\Orders\Events\OrderPaymentSuccessful;
use Dystore\Api\Domain\Payments\PaymentTypes\OfflinePaymentType;
use Lunar\Base\DataTransferObjects\PaymentAuthorize;
use Lunar\Facades\Payments;
use Lunar\Models\Contracts\Cart as CartContract;
use Lunar\Models\Contracts\Order as OrderContract;

class AuthorizeOfflinePayment
{
    /**
     * @param  array<string,mixed>  $meta
     */
    public function __invoke(?OrderContract $order, ?CartContract $cart, string $paymentType = 'offline', ?array $meta = null): void
    {
        if (! $order && ! $cart) {
            throw new \InvalidArgumentException('Either order or cart must be provided');
        }

        /** @var OfflinePaymentType $driver */
        $driver = Payments::driver('offline');

        if ($cart) {
            $driver->cart($cart);
        }

        if ($order) {
            $driver->order($order);
        }

        $driver->withData([
            'meta' => array_merge(
                ['payment_type' => $paymentType],
                $meta ?? [],
            ),
        ]);

        /** @var PaymentAuthorize $authorization */
        $authorization = $driver->authorize($paymentType);

        if (! $authorization->success) {
            report("Payment failed for order: {$order->id} with reason: {$authorization->message}");

            return;
        }

        OrderPaymentSuccessful::dispatch($order);
    }
}
