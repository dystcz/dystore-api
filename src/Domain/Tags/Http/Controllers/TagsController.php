<?php

namespace Dystore\Api\Domain\Tags\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\Tags\Contracts\TagsController as TagsControllerContract;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchMany;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchOne;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchRelated;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchRelationship;

class TagsController extends Controller implements TagsControllerContract
{
    use FetchMany;
    use FetchOne;
    use FetchRelated;
    use FetchRelationship;
}
