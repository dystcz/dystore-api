<?php

namespace Dystore\Api\Domain\Attributes\Contracts;

use Dystore\Api\Base\Contracts\Translatable;
use Lunar\Models\Contracts\Attribute as LunarAttribute;

interface Attribute extends LunarAttribute, Translatable {}
