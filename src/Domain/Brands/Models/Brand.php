<?php

namespace Dystore\Api\Domain\Brands\Models;

use Dystore\Api\Domain\Brands\Concerns\InteractsWithDystoreApi;
use Dystore\Api\Domain\Brands\Contracts\Brand as BrandContract;
use Lunar\Models\Brand as LunarBrand;

class Brand extends LunarBrand implements BrandContract
{
    use InteractsWithDystoreApi;
}
