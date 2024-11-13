<?php

namespace Dystore\Api\Domain\Orders\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\Orders\Contracts\MarkOrderAwaitingPaymentController as MarkOrderAwaitingPaymentControllerContract;
use Dystore\Api\Domain\Orders\Models\Order;
use Dystore\Api\Domain\Payments\Actions\MarkAwaitingPayment;
use LaravelJsonApi\Core\Responses\DataResponse;
use Lunar\Models\Contracts\Order as OrderContract;

class MarkOrderAwaitingPaymentController extends Controller implements MarkOrderAwaitingPaymentControllerContract
{
    public function markAwaitingPayment(
        OrderContract $order,
        MarkAwaitingPayment $markAwaitingPayment,
    ): DataResponse {
        /** @var Order $order */
        $this->authorize('viewSigned', $order);

        $order = $markAwaitingPayment($order);

        return DataResponse::make($order)
            ->didntCreate();
    }
}
