<?php

namespace Dystcz\LunarApi\Domain\Orders\Http\Controllers;

use Dystcz\LunarApi\Base\Controller;
use Dystcz\LunarApi\Domain\Orders\Contracts\MarkOrderPendingPaymentController as MarkOrderPendingPaymentControllerContract;
use Dystcz\LunarApi\Domain\Orders\Models\Order;
use Dystcz\LunarApi\Domain\Payments\Actions\MarkPendingPayment;
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
