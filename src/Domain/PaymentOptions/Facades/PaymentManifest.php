<?php

namespace Dystore\Api\Domain\PaymentOptions\Facades;

use Dystore\Api\Domain\PaymentOptions\Contracts\PaymentManifest as PaymentManifestContract;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Dystore\Api\Domain\PaymentOptions\Manifests\PaymentManifest addOption(\Dystore\Api\Domain\PaymentOptions\Entities\PaymentOption $option)
 * @method static \Dystore\Api\Domain\PaymentOptions\Manifests\PaymentManifest addOptions(\Illuminate\Support\Collection $options)
 * @method static \Dystore\Api\Domain\PaymentOptions\Manifests\PaymentManifest clearOptions()
 * @method static \Dystore\Api\Domain\PaymentOptions\Manifests\PaymentManifest getOptionUsing(\Closure $closure)
 * @method static \Illuminate\Support\Collection getOptions(\Lunar\Models\Contracts\Cart $cart, bool $withHidden = false)
 * @method static \Dystore\Api\Domain\PaymentOptions\Entities\PaymentOption|null getOption(\Lunar\Models\Contracts\Cart $cart, string $identifier, bool $withHidden = true)
 * @method static \Dystore\Api\Domain\PaymentOptions\Entities\PaymentOption|null getPaymentOption(\Lunar\Models\Contracts\Cart $cart, bool $withHidden = false)
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
