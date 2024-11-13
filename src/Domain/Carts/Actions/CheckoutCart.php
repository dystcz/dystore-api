<?php

namespace Dystore\Api\Domain\Carts\Actions;

use Dystore\Api\Domain\Carts\Contracts\CheckoutCart as CheckoutCartContract;
use Dystore\Api\Domain\Carts\Models\Cart;
use Dystore\Api\Domain\Orders\Events\OrderCreated;
use Dystore\Api\Domain\Payments\Actions\CreatePaymentIntent;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Lunar\Base\CartSessionInterface;
use Lunar\Models\Contracts\Cart as CartContract;
use Lunar\Models\Contracts\Order as OrderContract;
use Lunar\Models\Order;

class CheckoutCart implements CheckoutCartContract
{
    /**
     * @var CartSessionManager
     */
    private CartSessionInterface $cartSession;

    private CreatePaymentIntent $createPaymentIntent;

    public function __construct()
    {
        $this->cartSession = App::make(CartSessionInterface::class);

        $this->createPaymentIntent = App::make(CreatePaymentIntent::class);
    }

    /**
     * Checkout cart.
     */
    public function __invoke(CartContract $cart): OrderContract
    {
        /** @var Cart $cart */
        /** @var Order $order */
        $order = $cart->createOrder(
            allowMultipleOrders: Config::get('lunar-api.general.checkout.multiple_orders_per_cart', false),
        );

        $model = Order::modelClass()::query()
            ->with([
                'cart' => fn ($query) => $query->with(Config::get('lunar.cart.eager_load', [])),
            ])
            ->where('id', $order->id)
            ->firstOrFail();

        if ($paymentOption = $cart->getPaymentOption()) {
            $drivers = Config::get('lunar-api.general.checkout.auto_create_payment_intent_for_drivers', []);

            if (in_array($paymentOption->getDriver(), $drivers)) {
                ($this->createPaymentIntent)($paymentOption->getDriver(), $model->cart);
            }
        }

        if (Config::get('lunar-api.general.checkout.forget_cart_after_order_creation', true)) {
            $this->cartSession->forget(delete: false);
        }

        OrderCreated::dispatch($model);

        return $model;
    }
}
