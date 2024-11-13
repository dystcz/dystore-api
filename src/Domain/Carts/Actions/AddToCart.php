<?php

namespace Dystore\Api\Domain\Carts\Actions;

use Dystore\Api\Domain\CartLines\Data\CartLineData;
use Dystore\Api\Domain\CartLines\Models\CartLine;
use Dystore\Api\Domain\Carts\Models\Cart;
use Dystore\Api\Support\Actions\Action;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\App;
use Lunar\Base\CartSessionInterface;
use Lunar\Managers\CartSessionManager;
use Lunar\Models\Contracts\Cart as CartContract;
use Lunar\Models\Contracts\CartLine as CartLineContract;

class AddToCart extends Action
{
    protected CartSessionManager $cartSession;

    public function __construct(
    ) {
        $this->cartSession = App::make(CartSessionInterface::class);
    }

    public function handle(CartLineData $data): array
    {
        /** @var Cart $cart */
        $cart = $this->getCart();

        $purchasable = Relation::getMorphedModel($data->purchasable_type)::find($data->purchasable_id);

        $cart = $cart->add(
            purchasable: $purchasable,
            quantity: $data->quantity,
            meta: $data->meta ?? []
        );

        $cartLine = $cart->lines->firstWhere(
            /** @var CartLine $cartLine */
            fn (CartLineContract $cartLine) => $cartLine->purchasable->is($purchasable)
        );

        $this->cartSession->use($cart);

        return [$cart, $cartLine];
    }

    /**
     * Get cart from session or create a new one.
     */
    private function getCart(): CartContract
    {
        /** @var Cart $cart */
        return $this->cartSession->current() ?? CreateCart::run();
    }
}
