<?php

namespace Dystore\Api\Domain\CustomerGroups\Models;

use Dystore\Api\Domain\CustomerGroups\Concerns\InteractsWithDystoreApi;
use Dystore\Api\Domain\CustomerGroups\Contracts\CustomerGroup as CustomerGroupContract;
use Lunar\Models\CustomerGroup as LunarCustomerGroup;

class CustomerGroup extends LunarCustomerGroup implements CustomerGroupContract
{
    use InteractsWithDystoreApi;
}
