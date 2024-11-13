<?php

namespace Dystore\Api\Domain\Collections\Contracts;

use Dystore\Api\Base\Contracts\Translatable;
use Lunar\Models\Contracts\Collection as LunarCollection;

interface Collection extends LunarCollection, Translatable {}
