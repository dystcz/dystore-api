<?php

namespace Dystore\Api\Domain\Orders\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\Orders\Contracts\OrdersController as OrdersControllerContract;
use Dystore\Api\Domain\Orders\JsonApi\V1\OrderQuery;
use Dystore\Api\Domain\Orders\JsonApi\V1\OrderSchema;
use Dystore\Api\Domain\Orders\Models\Order;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchOne;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchRelated;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchRelationship;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\Update;
use Lunar\Models\Contracts\Order as OrderContract;

class OrdersController extends Controller implements OrdersControllerContract
{
    use FetchOne;
    use FetchRelated;
    use FetchRelationship;
    use Update;

    /**
     * Fetch zero to one JSON API resource by id.
     *
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function show(OrderSchema $schema, OrderQuery $request, OrderContract $order): DataResponse
    {
        /** @var Order $model */
        $model = $schema
            ->repository()
            ->queryOne($order)
            ->withRequest($request)
            ->first();

        return DataResponse::make($model)
            ->didntCreate();
    }
}
