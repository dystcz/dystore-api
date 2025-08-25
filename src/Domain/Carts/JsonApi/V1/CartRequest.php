<?php

namespace Dystore\Api\Domain\Carts\JsonApi\V1;

use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

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
            'customer' => ['nullable', 'array'],
            'customer.type' => ['required_with:customer', 'in:customers'],
            'customer.id' => ['required_with:customer', 'string'],
        ];
    }
}
