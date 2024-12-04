<?php

namespace Dystore\Api\Domain\Urls\Models;

use Dystore\Api\Domain\Urls\Concerns\InteractsWithDystoreApi;
use Dystore\Api\Domain\Urls\Contracts\Url as UrlContract;
use Lunar\Models\Url as LunarUrl;

class Url extends LunarUrl implements UrlContract
{
    use InteractsWithDystoreApi;
}
