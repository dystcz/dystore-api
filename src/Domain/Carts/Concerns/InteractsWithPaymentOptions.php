<?php

namespace Dystore\Api\Domain\Carts\Concerns;

use Dystore\Api\Domain\Carts\Actions\SetPaymentOption;
use Dystore\Api\Domain\Carts\Actions\UnsetPaymentOption;
use Dystore\Api\Domain\Carts\ValueObjects\PaymentBreakdown;
use Dystore\Api\Domain\PaymentOptions\Entities\PaymentOption;
use Dystore\Api\Domain\PaymentOptions\Facades\PaymentManifest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Lunar\Base\ValueObjects\Cart\TaxBreakdown;
use Lunar\DataTypes\Price;
use Lunar\Models\Cart;
use Lunar\Models\Contracts\Cart as CartContract;

trait InteractsWithPaymentOptions
{
    /**
     * The applied payment option.
     */
    public ?PaymentOption $paymentOption = null;

    /**
     * The payment sub total for the cart.
     */
    public ?Price $paymentSubTotal = null;

    /**
     * The payment tax total for the cart.
     */
    public ?Price $paymentTaxTotal = null;

    /**
     * The payment total for the cart.
     */
    public ?Price $paymentTotal = null;

    /**
     * Additional payment estimate meta data.
     */
    public array $paymentEstimateMeta = [];

    /**
     * All the payment breakdowns for the cart.
     */
    public ?PaymentBreakdown $paymentBreakdown = null;

    /**
     * Payment tax breakdown for the cart.
     *
     * @var null|Collection<TaxBreakdown>
     */
    public ?TaxBreakdown $paymentTaxBreakdown = null;

    /**
     * Set the payment option for the cart.
     */
    public function setPaymentOption(PaymentOption $option, bool $refresh = true): CartContract
    {
        /** @var Cart $cart */
        $cart = $this;

        foreach (Config::get('lunar.cart.validators.set_payment_option', []) as $action) {
            App::make($action)->using(cart: $cart, paymentOption: $option)->validate();
        }

        return App::make(Config::get('lunar.cart.actions.set_payment_option', SetPaymentOption::class))
            ->execute($cart, $option)
            ->then(fn () => $refresh ? $cart->refresh()->calculate() : $cart);
    }

    /**
     * Unset the payment option from the cart.
     */
    public function unsetPaymentOption(bool $refresh = true): Cart
    {
        /** @var Cart $cart */
        $cart = $this;

        return App::make(Config::get('lunar.cart.actions.unset_payment_option', UnsetPaymentOption::class))
            ->execute($cart)
            ->then(fn () => $refresh ? $cart->refresh()->calculate() : $cart);
    }

    /**
     * Get the payment option for the cart
     */
    public function getPaymentOption(): ?PaymentOption
    {
        /** @var Cart $cart */
        $cart = $this;

        return PaymentManifest::getPaymentOption($cart);
    }
}
