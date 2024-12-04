<?php

namespace Dystore\Api\Domain\ShippingOptions\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\ShippingOptions\Contracts\ShippingOptionsController as ShippingOptionsControllerContract;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchMany;

class ShippingOptionsController extends Controller implements ShippingOptionsControllerContract
{
    use FetchMany;
}
