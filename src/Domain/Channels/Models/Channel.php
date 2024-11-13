<?php

namespace Dystore\Api\Domain\Channels\Models;

use Dystore\Api\Domain\Channels\Concerns\InteractsWithLunarApi;
use Dystore\Api\Domain\Channels\Contracts\Channel as ChannelContract;
use Lunar\Models\Channel as LunarChannel;

class Channel extends LunarChannel implements ChannelContract
{
    use InteractsWithLunarApi;
}
