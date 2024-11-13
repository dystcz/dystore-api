<?php

namespace Dystore\Api\Domain\AttributeGroups\Contracts;

use Dystore\Api\Base\Contracts\Translatable;
use Lunar\Models\Contracts\AttributeGroup as LunarAttributeGroup;

interface AttributeGroup extends LunarAttributeGroup, Translatable {}
