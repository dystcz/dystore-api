<?php

namespace Dystore\Api\Domain\Carts\JsonApi\V1;

use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class CartRequest extends ResourceRequest
{
    /**
     * Get the rules that apply to the request.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'customer' => JsonApiRule::toOne(),
        ];
    }
}
