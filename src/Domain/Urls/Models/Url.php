<?php

namespace Dystore\Api\Domain\Urls\Models;

use Dystore\Api\Domain\Urls\Concerns\InteractsWithLunarApi;
use Dystore\Api\Domain\Urls\Contracts\Url as UrlContract;
use Lunar\Models\Url as LunarUrl;

class Url extends LunarUrl implements UrlContract
{
    use InteractsWithLunarApi;
}
