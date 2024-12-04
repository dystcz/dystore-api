<?php

namespace Dystore\Api\Domain\Brands\Contracts;

use Dystore\Api\Base\Contracts\Translatable;
use Lunar\Models\Contracts\Brand as LunarBrand;

interface Brand extends LunarBrand, Translatable {}
