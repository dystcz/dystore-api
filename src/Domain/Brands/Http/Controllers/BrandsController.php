<?php

namespace Dystore\Api\Domain\Brands\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\Brands\Contracts\BrandsController as BrandsControllerContract;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchMany;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchOne;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchRelated;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchRelationship;

class BrandsController extends Controller implements BrandsControllerContract
{
    use FetchMany;
    use FetchOne;
    use FetchRelated;
    use FetchRelationship;
}
