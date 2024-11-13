<?php

namespace Dystore\Api\Domain\CollectionGroups\Models;

use Dystore\Api\Domain\CollectionGroups\Concerns\InteractsWithLunarApi;
use Dystore\Api\Domain\CollectionGroups\Contracts\CollectionGroup as CollectionGroupContract;
use Lunar\Models\CollectionGroup as LunarCollectionGroup;

class CollectionGroup extends LunarCollectionGroup implements CollectionGroupContract
{
    use InteractsWithLunarApi;
}
