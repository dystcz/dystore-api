<?php

namespace Dystore\Api\Domain\Products\Contracts;

use Dystore\Api\Base\Contracts\HasAvailability;
use Dystore\Api\Base\Contracts\Translatable;
use Lunar\Models\Contracts\Product as LunarProduct;

interface Product extends HasAvailability, LunarProduct, Translatable {}
