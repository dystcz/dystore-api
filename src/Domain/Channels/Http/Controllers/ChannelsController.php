<?php

namespace Dystore\Api\Domain\Channels\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\Channels\Contracts\ChannelsController as ChannelsControllerContract;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchMany;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchOne;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchRelated;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchRelationship;

class ChannelsController extends Controller implements ChannelsControllerContract
{
    use FetchMany;
    use FetchOne;
    use FetchRelated;
    use FetchRelationship;
}
