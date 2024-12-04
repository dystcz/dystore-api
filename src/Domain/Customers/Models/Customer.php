<?php

namespace Dystore\Api\Domain\Customers\Models;

use Dystore\Api\Domain\Customers\Concerns\InteractsWithDystoreApi;
use Dystore\Api\Domain\Customers\Contracts\Customer as CustomerContract;
use Lunar\Models\Customer as LunarCustomer;

/**
 * @method HasMany attributes()
 */
class Customer extends LunarCustomer implements CustomerContract
{
    use InteractsWithDystoreApi;
}
