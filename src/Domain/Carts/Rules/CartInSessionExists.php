<?php

namespace Dystore\Api\Domain\Carts\Rules;

use Closure;
use Dystore\Api\Domain\Carts\Contracts\CurrentSessionCart;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\App;
use Lunar\Models\Contracts\Cart as CartContract;

class CartInSessionExists implements ValidationRule
{
    protected ?CartContract $cart;

    public function __construct(
    ) {
        $this->cart = App::make(CurrentSessionCart::class);
    }

    /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected array $data = [];

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $this->cart instanceof CartContract) {
            $fail(__('validation.carts.session.exists'));
        }
    }
}
