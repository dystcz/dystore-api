<?php

namespace Dystcz\LunarApi\Domain\Customers\Http\Controllers;

use Dystcz\LunarApi\Controller;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class CustomersController extends Controller
{
    // use Actions\FetchMany;
    use Actions\FetchOne;

    // use Actions\Store;
    use Actions\Update;
    // use Actions\Destroy;
    use Actions\FetchRelated;
    use Actions\FetchRelationship;

    // use Actions\UpdateRelationship;
    // use Actions\AttachRelationship;
    // use Actions\DetachRelationship;
}