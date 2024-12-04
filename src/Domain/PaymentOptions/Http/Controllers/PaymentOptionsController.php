<?php

namespace Dystore\Api\Domain\PaymentOptions\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\PaymentOptions\Contracts\PaymentOptionsController as PaymentOptionsControllerContract;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchMany;

class PaymentOptionsController extends Controller implements PaymentOptionsControllerContract
{
    use FetchMany;
}
