<?php

namespace Dystore\Api\Base\Concerns;

use Dystore\Api\Domain\Payments\Contracts\HandlePaymentWebhookController;
use Dystore\Api\Support\Config\Actions\RegisterRoutesFromConfig;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

trait HasRoutes
{
    public function routes(): static
    {
        // API routes
        Route::group([
            'prefix' => Config::get('dystore.general.route_prefix'),
            'middleware' => Config::get('dystore.general.route_middleware'),
        ], fn () => RegisterRoutesFromConfig::run());

        // Webhooks
        Route::post('{paymentDriver}/webhook', HandlePaymentWebhookController::class)
            ->name('payments.webhook');

        return $this;
    }
}
