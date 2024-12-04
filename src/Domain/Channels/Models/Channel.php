<?php

namespace Dystore\Api\Domain\Channels\Models;

use Dystore\Api\Domain\Channels\Concerns\InteractsWithDystoreApi;
use Dystore\Api\Domain\Channels\Contracts\Channel as ChannelContract;
use Lunar\Models\Channel as LunarChannel;

class Channel extends LunarChannel implements ChannelContract
{
    use InteractsWithDystoreApi;
}
