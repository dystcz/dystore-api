<?php

namespace Dystore\Api\Domain\Orders\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\Orders\Contracts\MarkOrderPendingPaymentController as MarkOrderPendingPaymentControllerContract;
use Dystore\Api\Domain\Orders\Models\Order;
use Dystore\Api\Domain\Payments\Actions\MarkPendingPayment;
use LaravelJsonApi\Core\Responses\DataResponse;
use Lunar\Models\Contracts\Order as OrderContract;

class MarkOrderPendingPaymentController extends Controller implements MarkOrderPendingPaymentControllerContract
{
    public function markPendingPayment(
        OrderContract $order,
        MarkPendingPayment $markPendingPayment,
    ): DataResponse {
        /** @var Order $order */
        $this->authorize('viewSigned', $order);

        $order = $markPendingPayment($order);

        return DataResponse::make($order)
            ->didntCreate();
    }
}
