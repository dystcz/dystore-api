<?php

namespace Dystore\Api\Domain\PaymentOptions\Facades;

use Closure;
use Dystore\Api\Domain\PaymentOptions\Contracts\PaymentManifest as PaymentManifestContract;
use Dystore\Api\Domain\PaymentOptions\Entities\PaymentOption;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Lunar\Models\Contracts\Cart as CartContract;

/**
 * @method static PaymentManifest addOption(PaymentOption $option)
 * @method static PaymentManifest addOptions(Collection $options)
 * @method static PaymentManifest clearOptions()
 * @method static PaymentManifest getOptionUsing(Closure $closure)
 * @method static Collection getOptions(CartContract $cart)
 * @method static ?PaymentOption getOption(CartContract $cart, string $identifier)
 * @method static ?PaymentOption getPaymentOption(CartContract $cart)
 *
 * @see \Dystore\Api\Domain\PaymentOptions\Manifests\PaymentManifest
 */
class PaymentManifest extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor(): string
    {
        return PaymentManifestContract::class;
    }
}
