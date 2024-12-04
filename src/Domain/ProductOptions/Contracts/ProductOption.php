<?php

namespace Dystore\Api\Domain\ProductOptions\Contracts;

use Dystore\Api\Base\Contracts\Translatable;
use Lunar\Models\Contracts\ProductOption as LunarProductOption;

interface ProductOption extends LunarProductOption, Translatable {}
