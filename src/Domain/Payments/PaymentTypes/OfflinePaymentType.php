<?php

namespace Dystore\Api\Domain\Payments\PaymentTypes;

use Carbon\Carbon;
use Dystore\Api\Domain\Payments\Actions\GetLastOrderTransaction;
use Dystore\Api\Domain\Payments\Enums\PaymentIntentStatus;
use Dystore\Api\Domain\Payments\Enums\TransactionType;
use Dystore\Api\Domain\Payments\PaymentAdapters\PaymentAdaptersRegister;
use Lunar\Base\DataTransferObjects\PaymentAuthorize;
use Lunar\Base\DataTransferObjects\PaymentCapture;
use Lunar\Base\DataTransferObjects\PaymentRefund;
use Lunar\Events\PaymentAttemptEvent;
use Lunar\Exceptions\Carts\CartException;
use Lunar\Exceptions\DisallowMultipleCartOrdersException;
use Lunar\Models\Contracts\Transaction as TransactionContract;
use Lunar\PaymentTypes\AbstractPayment;

class OfflinePaymentType extends AbstractPayment
{
    public function __construct(
        protected PaymentAdaptersRegister $register
    ) {}

    /**
     * {@inheritDoc}
     */
    public function authorize(string $paymentType = 'offline'): PaymentAuthorize
    {
        $this->order = $this->order ?: ($this->cart->draftOrder ?: $this->cart->completedOrder);

        if (! $this->order) {
            try {
                $this->order = $this->cart->createOrder();
            } catch (DisallowMultipleCartOrdersException|CartException $e) {
                return $this->fail($e->getMessage(), $paymentType);
            }
        }

        $meta = array_merge(
            (array) $this->order->meta,
            $this->data['meta'] ?? []
        );

        $status = $this->data['authorized'] ?? null;

        $this->createCaptureTransaction($paymentType);

        $this->order->update([
            'status' => $status ?? $this->config['authorized'] ?? 'payment-received',
            'meta' => $meta,
            'placed_at' => Carbon::now(),
        ]);

        $authorization = new PaymentAuthorize(
            success: true,
            orderId: $this->order->id,
            paymentType: $paymentType,
        );

        PaymentAttemptEvent::dispatch($authorization);

        return $authorization;
    }

    public function fail(
        string $message = 'Failed to authorize payment',
        string $paymentType = 'offline',
    ): PaymentAuthorize {
        $failure = new PaymentAuthorize(
            success: false,
            message: $message,
            orderId: $this->order?->id,
            paymentType: $paymentType,
        );

        PaymentAttemptEvent::dispatch($failure);

        return $failure;
    }

    /**
     * {@inheritDoc}
     */
    public function refund(TransactionContract $transaction, int $amount = 0, $notes = null): PaymentRefund
    {
        return new PaymentRefund(true);
    }

    /**
     * {@inheritDoc}
     */
    public function capture(TransactionContract $transaction, $amount = 0): PaymentCapture
    {
        return new PaymentCapture(true);
    }

    /**
     * Create transaction for the payment.
     */
    protected function createCaptureTransaction(string $paymentType = 'offline'): TransactionContract
    {
        $paymentAdapter = $this->register->get($paymentType);

        $lastTransaction = (new GetLastOrderTransaction)(order: $this->order, driver: $paymentAdapter->getDriver())
            ?? $this->createIntentTransaction($paymentType);

        $transaction = $paymentAdapter->createTransaction(
            model: $this->order,
            type: TransactionType::CAPTURE,
            reference: "{$paymentType}-{$this->order->reference}",
            status: PaymentIntentStatus::SUCCEEDED->value,
            success: true,
            amount: $this->order->total->value,
            meta: $this->data['meta'] ?? [],
        );

        return $transaction;
    }

    protected function createIntentTransaction(string $paymentType = 'offline'): TransactionContract
    {
        $paymentAdapter = $this->register->get($paymentType);

        $transaction = $paymentAdapter->createTransaction(
            model: $this->order,
            type: TransactionType::INTENT,
            reference: "{$paymentType}-{$this->order->reference}",
            status: PaymentIntentStatus::INTENT->value,
            success: true,
            amount: $this->order->total->value,
            meta: $this->data['meta'] ?? [],
        );

        return $transaction;
    }
}
