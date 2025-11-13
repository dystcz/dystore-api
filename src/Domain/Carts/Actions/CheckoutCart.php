<?php

namespace Dystore\Api\Domain\Carts\Actions;

use Dystore\Api\Domain\Carts\Contracts\CheckoutCart as CheckoutCartContract;
use Dystore\Api\Domain\Carts\Events\CartCheckedOut;
use Dystore\Api\Domain\Carts\JsonApi\V1\CheckoutCartRequest;
use Dystore\Api\Domain\Carts\Models\Cart;
use Dystore\Api\Domain\Payments\Actions\CreatePaymentIntent;
use Dystore\Api\Support\Actions\Action;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;
use Lunar\Base\CartSessionInterface;
use Lunar\Exceptions\Carts\CartException;
use Lunar\Models\Contracts\Cart as CartContract;
use Lunar\Models\Contracts\Order as OrderContract;
use Lunar\Models\Order;

class CheckoutCart extends Action implements CheckoutCartContract
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

    public function handle(CartContract $cart, ?CheckoutCartRequest $request = null): OrderContract
    {
        /** @var Cart $cart */
        /** @var Order $order */
        try {
            $order = $cart->createOrder(
                allowMultipleOrders: Config::get('lunar.cart_session.allow_multiple_orders_per_cart', false),
            );
        } catch (CartException $e) {
            throw ValidationException::withMessages($e->errors()->getMessages());
        }

        // Update order from checkout request
        $order->update(
            $request?->validated('order_data', []) ?? []
        );

        // Load cart to order
        $order->load([
            'cart' => fn ($query) => $query->with(
                Config::get('lunar.cart.eager_load', [])
            ),
        ]);

        if ($paymentOption = $cart->getPaymentOption()) {
            $drivers = Config::get('dystore.general.checkout.auto_create_payment_intent_for_drivers', []);

            if (in_array($paymentOption->getDriver(), $drivers)) {
                ($this->createPaymentIntent)($paymentOption->getDriver(), $order->cart);
            }
        }

        if (Config::get('dystore.general.checkout.forget_cart_after_order_creation', true)) {
            $this->cartSession->forget(delete: false);
        }

        CartCheckedOut::dispatch($cart, $order);

        return $order;
    }
}
