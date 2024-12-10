<?php

namespace Dystore\Api\Domain\Storefront\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\Storefront\Contracts\StorefrontController as StorefrontControllerContract;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\Destroy;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchMany;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchOne;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchRelated;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchRelationship;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\UpdateRelationship;

class StorefrontController extends Controller implements StorefrontControllerContract
{
    use Destroy;
    use FetchMany;
    use FetchOne;
    use FetchRelated;
    use FetchRelationship;
    use UpdateRelationship;
}
