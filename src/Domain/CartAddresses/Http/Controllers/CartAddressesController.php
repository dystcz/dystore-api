<?php

namespace Dystcz\LunarApi\Domain\CartAddresses\Http\Controllers;

use Dystcz\LunarApi\Base\Controller;
use Dystcz\LunarApi\Domain\CartAddresses\Contracts\CartAddressesController as CartAddressesControllerContract;
use Dystcz\LunarApi\Domain\CartAddresses\JsonApi\V1\CartAddressQuery;
use Dystcz\LunarApi\Domain\CartAddresses\JsonApi\V1\CartAddressRequest;
use Dystcz\LunarApi\Domain\CartAddresses\JsonApi\V1\CartAddressSchema;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\Store;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\Update;
use Lunar\Models\CartAddress;
use Lunar\Models\Contracts\CartAddress as CartAddressContract;

class CartAddressesController extends Controller implements CartAddressesControllerContract
{
    use Store;
    use Update;

    /**
     * Create a new resource.
     *
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function store(
        CartAddressSchema $schema,
        CartAddressRequest $request,
        CartAddressQuery $query,
    ): DataResponse {
        $this->authorize('create', CartAddress::modelClass());

        $meta = [
            ...$request->validated('meta') ?? [],
            'company_in' => $request->validated('company_in', null),
            'company_tin' => $request->validated('company_tin', null),
        ];

        $model = $schema
            ->repository()
            ->create()
            ->withRequest($query)
            ->store(
                array_merge(
                    $request->validated(),
                    ['meta' => $meta],
                ),
            );

        return DataResponse::make($model)
            ->didCreate();
    }

    /**
     * Update an existing resource.
     *
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function update(
        CartAddressSchema $schema,
        CartAddressRequest $request,
        CartAddressQuery $query,
        CartAddressContract $cartAddress,
    ): DataResponse {
        $this->authorize('update', $cartAddress);

        $meta = array_merge($cartAddress->meta?->toArray() ?? [], [
            ...$request->validated('meta') ?? [],
            'company_in' => $request->validated('company_in', null),
            'company_tin' => $request->validated('company_tin', null),
        ]);

        $model = $schema
            ->repository()
            ->update($cartAddress)
            ->withRequest($query)
            ->store(
                array_merge(
                    $request->validated(),
                    ['meta' => $meta],
                ),
            );

        return DataResponse::make($model)
            ->didntCreate();
    }
}
