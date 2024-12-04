<?php

namespace Dystore\Api\Domain\Media\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\Media\Contracts\MediaController as MediaControllerContract;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchOne;

class MediaController extends Controller implements MediaControllerContract
{
    use FetchOne;
}
