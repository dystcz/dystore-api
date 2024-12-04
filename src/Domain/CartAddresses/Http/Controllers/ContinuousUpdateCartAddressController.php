<?php

namespace Dystore\Api\Domain\CartAddresses\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\CartAddresses\Contracts\ContinuousUpdateCartAddressController as ContinuousUpdateCartAddressControllerContract;
use Dystore\Api\Domain\CartAddresses\JsonApi\V1\CartAddressContinuousUpdateRequest;
use Dystore\Api\Domain\CartAddresses\JsonApi\V1\CartAddressQuery;
use Dystore\Api\Domain\CartAddresses\JsonApi\V1\CartAddressSchema;
use LaravelJsonApi\Core\Responses\DataResponse;
use Lunar\Models\Contracts\CartAddress as CartAddressContract;

class ContinuousUpdateCartAddressController extends Controller implements ContinuousUpdateCartAddressControllerContract
{
    public function continuousUpdate(
        CartAddressSchema $schema,
        CartAddressContinuousUpdateRequest $request,
        CartAddressQuery $query,
        CartAddressContract $cartAddress,
    ): DataResponse {
        $this->authorize('update', $cartAddress);

        $meta = array_merge(
            $cartAddress->meta?->toArray() ?? [],
            [
                'company_in' => $request->validated('company_in', null),
                'company_tin' => $request->validated('company_tin', null),
            ],
        );

        $model = $schema
            ->repository()
            ->update($cartAddress)
            ->withRequest($query)
            ->store(
                array_merge($request->validated(), ['meta' => $meta]),
            );

        return DataResponse::make($model)
            ->didntCreate();
    }
}
