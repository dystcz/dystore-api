<?php

namespace Dystore\Api\Domain\ProductAssociations\Models;

use Dystore\Api\Domain\ProductAssociations\Concerns\InteractsWithLunarApi;
use Dystore\Api\Domain\ProductAssociations\Contracts\ProductAssociation as ProductAssociationContract;
use Lunar\Models\ProductAssociation as LunarProductAssociation;

class ProductAssociation extends LunarProductAssociation implements ProductAssociationContract
{
    use InteractsWithLunarApi;
}
