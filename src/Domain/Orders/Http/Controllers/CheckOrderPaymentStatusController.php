<?php

namespace Dystcz\LunarApi\Domain\Orders\Http\Controllers;

use Dystcz\LunarApi\Controller;
use Dystcz\LunarApi\Domain\Orders\JsonApi\V1\CheckOrderPaymentStatusQuery;
use Dystcz\LunarApi\Domain\Orders\JsonApi\V1\OrderSchema;
use Dystcz\LunarApi\Domain\Orders\Models\Order;
use LaravelJsonApi\Core\Responses\DataResponse;

class CheckOrderPaymentStatusController extends Controller
{
    public function checkOrderPaymentStatus(
        OrderSchema $schema,
        CheckOrderPaymentStatusQuery $query,
        Order $order,
    ): DataResponse {
        $this->authorize('viewSigned', $order);

        return DataResponse::make($order)
            ->withIncludePaths([
                'latest_transaction',
            ])
            ->withSparseFieldSets([
                'orders' => [
                    // 'latest_transaction',
                    'status',
                    'placed_at',
                ],
                'transactions' => [
                    'type',
                    'driver',
                    'status',
                    'success',
                    'error',
                ],
            ])
            ->withMeta([
                'is_placed' => $order->isPlaced(),
            ])
            ->didntCreate();
    }
}
