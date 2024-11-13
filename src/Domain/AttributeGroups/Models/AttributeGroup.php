<?php

namespace Dystore\Api\Domain\AttributeGroups\Models;

use Dystore\Api\Domain\AttributeGroups\Concerns\InteractsWithLunarApi;
use Dystore\Api\Domain\AttributeGroups\Contracts\AttributeGroup as AttributeGroupContract;
use Lunar\Models\AttributeGroup as LunarAttributeGroup;

class AttributeGroup extends LunarAttributeGroup implements AttributeGroupContract
{
    use InteractsWithLunarApi;
}
