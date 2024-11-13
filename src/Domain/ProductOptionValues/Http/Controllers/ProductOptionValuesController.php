<?php

namespace Dystore\Api\Domain\ProductOptionValues\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\ProductOptionValues\Contracts\ProductOptionValuesController as ProductOptionValuesControllerContract;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchMany;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchOne;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchRelated;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchRelationship;

class ProductOptionValuesController extends Controller implements ProductOptionValuesControllerContract
{
    use FetchMany;
    use FetchOne;
    use FetchRelated;
    use FetchRelationship;
}
