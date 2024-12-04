<?php

namespace Dystore\Api\Domain\Urls\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\Urls\Contracts\UrlsController as UrlsControllerContract;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchMany;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchOne;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchRelated;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchRelationship;

class UrlsController extends Controller implements UrlsControllerContract
{
    use FetchMany;
    use FetchOne;
    use FetchRelated;
    use FetchRelationship;
}
