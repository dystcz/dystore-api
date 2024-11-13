<?php

namespace Dystore\Api\Domain\Carts\Models;

use Dystore\Api\Domain\Carts\Concerns\InteractsWithLunarApi;
use Dystore\Api\Domain\Carts\Contracts\Cart as CartContract;
use Dystore\Api\Domain\Carts\ValueObjects\PaymentBreakdown;
use Dystore\Api\Domain\PaymentOptions\Entities\PaymentOption;
use Lunar\Base\ValueObjects\Cart\TaxBreakdown;
use Lunar\DataTypes\Price;
use Lunar\Models\Cart as LunarCart;

/**
 * @property PaymentOption|null $paymentOption
 * @property Price|null $paymentSubTotal
 * @property Price|null $paymentTaxTotal
 * @property Price|null $paymentTotal
 * @property PaymentOption|null $paymentOptionOverride
 * @property array $paymentEstimateMeta
 * @property PaymentBreakdown|null $paymentBreakdown
 * @property TaxBreakdown|null $paymentTaxBreakdown
 *
 * @method Cart setPaymentOption(PaymentOption $option, bool $refresh = true)
 * @method Cart unsetPaymentOption(PaymentOption $option, bool $refresh = true)
 * @method ?PaymentOption getPaymentOption()
 */
class Cart extends LunarCart implements CartContract
{
    use InteractsWithLunarApi;
}
