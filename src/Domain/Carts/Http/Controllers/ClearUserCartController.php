<?php

namespace Dystore\Api\Domain\Carts\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\Carts\Contracts\ClearUserCartController as ClearUserCartControllerContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Lunar\Base\CartSessionInterface;
use Lunar\Managers\CartSessionManager;

class ClearUserCartController extends Controller implements ClearUserCartControllerContract
{
    /**
     * @var CartSessionManager
     */
    private CartSessionInterface $cartSession;

    public function __construct()
    {
        $this->cartSession = App::make(CartSessionInterface::class);
    }

    /**
     * Clear all items from user's cart.
     */
    public function clear(): JsonResponse
    {
        //TODO: Create tests
        $this->authorize('clear', $this->cartSession->current());

        $this->cartSession->forget();

        return new JsonResponse(status: 204);
    }
}
