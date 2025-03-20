<?php

namespace Dystore\Api\Domain\CartLines\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\CartLines\Actions\UpdateCartLine;
use Dystore\Api\Domain\CartLines\Contracts\CartLinesController as CartLinesControllerContract;
use Dystore\Api\Domain\CartLines\Data\CartLineData;
use Dystore\Api\Domain\CartLines\JsonApi\V1\CartLineQuery;
use Dystore\Api\Domain\CartLines\JsonApi\V1\CartLineRequest;
use Dystore\Api\Domain\Carts\Actions\AddToCart;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\Destroy;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\Store;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\Update;
use Lunar\Exceptions\Carts\CartException;
use Lunar\Models\Contracts\CartLine as CartLineContract;

class CartLinesController extends Controller implements CartLinesControllerContract
{
    use Destroy;
    use Store;
    use Update;

    /*
     * Add cart line to cart.
     */
    public function creating(CartLineRequest $request, CartLineQuery $query): DataResponse
    {
        $data = CartLineData::fromRequest($request);

        try {
            [, $cartLine] = App::make(AddToCart::class)($data);
        } catch (CartException $e) {
            throw ValidationException::withMessages($e->errors()->getMessages());
        }

        return DataResponse::make($cartLine)
            ->withQueryParameters($query)
            ->didCreate();
    }

    /*
     * Update cart line.
     */
    public function updating(CartLineContract $cartLine, CartLineRequest $request, CartLineQuery $query): DataResponse
    {
        $data = CartLineData::fromRequest($request);

        try {
            [, $cartLine] = App::make(UpdateCartLine::class)($data, $cartLine);
        } catch (CartException $e) {
            throw ValidationException::withMessages($e->errors()->getMessages());
        }

        return DataResponse::make($cartLine)
            ->withQueryParameters($query)
            ->didntCreate();
    }
}
