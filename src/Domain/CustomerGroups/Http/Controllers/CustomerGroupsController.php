<?php

namespace Dystore\Api\Domain\CustomerGroups\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\CustomerGroups\Contracts\CustomerGroupsController as CustomerGroupsControllerContract;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchMany;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchOne;

class CustomerGroupsController extends Controller implements CustomerGroupsControllerContract
{
    use FetchMany;
    use FetchOne;
}
