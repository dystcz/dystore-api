<?php

namespace Dystore\Api\Domain\Tags\Models;

use Dystore\Api\Domain\Tags\Concerns\InteractsWithLunarApi;
use Dystore\Api\Domain\Tags\Contracts\Tag as TagContract;
use Lunar\Models\Tag as LunarTag;

class Tag extends LunarTag implements TagContract
{
    use InteractsWithLunarApi;
}
