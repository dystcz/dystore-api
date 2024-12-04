<?php

namespace Dystore\Api\Domain\Currencies\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\Currencies\Contracts\CurrenciesController as CurrenciesControllerContract;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchMany;

class CurrenciesController extends Controller implements CurrenciesControllerContract
{
    use FetchMany;
}
