<?php

namespace Dystore\Api\Domain\ProductOptionValues\Contracts;

use Dystore\Api\Base\Contracts\Translatable;
use Lunar\Models\Contracts\ProductOptionValue as LunarProductOptionValue;

interface ProductOptionValue extends LunarProductOptionValue, Translatable {}
