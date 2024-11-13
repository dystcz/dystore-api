<?php

namespace Dystore\Api;

use Dystore\Api\Api as DystoreApi;
use Dystore\Api\Domain\Carts\Actions\CheckoutCart;
use Dystore\Api\Domain\Carts\Actions\CreateUserFromCart;
use Dystore\Api\Domain\Users\Actions\CreateUser;
use Dystore\Api\Domain\Users\Actions\RegisterUser;
use Dystore\Api\Facades\Api;
use Dystore\Api\Support\Config\Collections\DomainConfigCollection;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Lunar\Base\CartSessionInterface;
use Lunar\Facades\ModelManifest;

class ApiServiceProvider extends ServiceProvider
{
    protected array $configFiles = [
        'domains',
        'general',
        'hashids',
    ];

    protected $root = __DIR__.'/..';

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->registerConfig();
        $this->setPaymentOptionsConfig();

        $this->loadTranslationsFrom(
            "{$this->root}/lang",
            'lunar-api',
        );

        $this->booting(function () {
            $this->registerPolicies();
        });

        // Register the main class to use with the facade.
        $this->app->singleton(
            'lunar-api',
            fn () => new DystoreApi,
        );

        $this->bindControllers();
        $this->bindModels();

        // Register payment adapters register.
        $this->app->singleton(
            \Dystore\Api\Domain\Payments\PaymentAdapters\PaymentAdaptersRegister::class,
            fn () => new \Dystore\Api\Domain\Payments\PaymentAdapters\PaymentAdaptersRegister,
        );

        // Register payment modifiers.
        $this->app->singleton(
            \Dystore\Api\Domain\PaymentOptions\Modifiers\PaymentModifiers::class,
            fn (Application $app) => new \Dystore\Api\Domain\PaymentOptions\Modifiers\PaymentModifiers,
        );

        // Register payment manifest.
        $this->app->singleton(
            \Dystore\Api\Domain\PaymentOptions\Contracts\PaymentManifest::class,
            fn (Application $app) => $app->make(\Dystore\Api\Domain\PaymentOptions\Manifests\PaymentManifest::class),
        );

    }

    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom("{$this->root}/routes/api.php");
        $this->loadMigrationsFrom("{$this->root}/database/migrations");

        $this->registerModels();
        $this->registerDynamicRelations();
        $this->registerObservers();
        $this->registerEvents();
        $this->registerPayments();

        Api::createUserUsing(CreateUser::class);
        Api::createUserFromCartUsing(CreateUserFromCart::class);
        Api::registerUserUsing(RegisterUser::class);
        Api::checkoutCartUsing(CheckoutCart::class);

        if ($this->app->runningInConsole()) {
            $this->publishConfig();
            $this->publishTranslations();
            $this->publishMigrations();
            $this->registerCommands();
        }
    }

    /**
     * Publish config files.
     */
    protected function publishConfig(): void
    {
        foreach ($this->configFiles as $configFile) {
            $this->publishes([
                "{$this->root}/config/{$configFile}.php" => config_path("lunar-api/{$configFile}.php"),
            ], 'lunar-api');
        }

        $this->publishes([
            "{$this->root}/config/jsonapi.php" => config_path('jsonapi.php'),
        ], 'jsonapi');
    }

    /**
     * Publish translations.
     */
    protected function publishTranslations(): void
    {
        $this->publishes([
            "{$this->root}/lang" => $this->app->langPath('vendor/lunar-api'),
        ], 'lunar-api.translations');
    }

    /**
     * Register config files.
     */
    protected function registerConfig(): void
    {
        foreach ($this->configFiles as $configFile) {
            $this->mergeConfigFrom(
                "{$this->root}/config/{$configFile}.php",
                "lunar-api.{$configFile}",
            );
        }

        $this->mergeConfigFrom(
            "{$this->root}/config/jsonapi.php",
            'jsonapi',
        );
    }

    /**
     * Set payment options config.
     */
    protected function setPaymentOptionsConfig(): void
    {
        // Push ApplyPayment pipeline after ApplyShipping pipeline
        $cartPipelines = Config::get('lunar.cart.pipelines.cart', []);

        // Push apply payment pipeline after apply shipping pipeline
        $applyShippingIndex = array_search(\Lunar\Pipelines\Cart\ApplyShipping::class, $cartPipelines);

        if (array_key_exists($applyShippingIndex, $cartPipelines)) {
            $cartPipelines = array_merge(
                array_slice($cartPipelines, 0, $applyShippingIndex + 1),
                [\Dystore\Api\Domain\Carts\Pipelines\ApplyPayment::class],
                array_slice($cartPipelines, $applyShippingIndex + 1),
            );
        }

        // Push calculate payment pipeline after calculate pipeline
        $calculateIndex = array_search(\Lunar\Pipelines\Cart\Calculate::class, $cartPipelines);

        if (array_key_exists($calculateIndex, $cartPipelines)) {
            $cartPipelines = array_merge(
                array_slice($cartPipelines, 0, $calculateIndex + 1),
                [\Dystore\Api\Domain\Carts\Pipelines\CalculatePayment::class],
                array_slice($cartPipelines, $calculateIndex + 1),
            );
        }

        // // NOTE: Workaround
        // // Swap calculate lines pipeline
        // $calculateLinesIndex = array_search(\Lunar\Pipelines\Cart\CalculateLines::class, $cartPipelines);
        // if (array_key_exists($calculateLinesIndex, $cartPipelines)) {
        //     $cartPipelines[$calculateLinesIndex] = \Dystore\Api\Domain\Carts\Pipelines\CalculateLines::class;
        // }
        //
        // // NOTE: Workaround
        // // Swap apply shipping pipeline
        // $applyShippingIndex = array_search(\Lunar\Pipelines\Cart\ApplyShipping::class, $cartPipelines);
        // if (array_key_exists($applyShippingIndex, $cartPipelines)) {
        //     $cartPipelines[$applyShippingIndex] = \Dystore\Api\Domain\Carts\Pipelines\ApplyShipping::class;
        // }
        //
        // // NOTE: Workaround
        // // Swap apply discounts pipeline
        // $applyDiscountsIndex = array_search(\Lunar\Pipelines\Cart\ApplyDiscounts::class, $cartPipelines);
        // if (array_key_exists($applyDiscountsIndex, $cartPipelines)) {
        //     $cartPipelines[$applyDiscountsIndex] = \Dystore\Api\Domain\Carts\Pipelines\ApplyDiscounts::class;
        // }
        //
        // // NOTE: Workaround
        // // Swap calculate tax pipeline
        // $calculateTaxIndex = array_search(\Lunar\Pipelines\Cart\CalculateTax::class, $cartPipelines);
        // if (array_key_exists($calculateTaxIndex, $cartPipelines)) {
        //     $cartPipelines[$calculateTaxIndex] = \Dystore\Api\Domain\Carts\Pipelines\CalculateTax::class;
        // }
        //
        // // NOTE: Workaround
        // // Swap calculate pipeline
        // $calculateIndex = array_search(\Lunar\Pipelines\Cart\Calculate::class, $cartPipelines);
        // if (array_key_exists($calculateIndex, $cartPipelines)) {
        //     $cartPipelines[$calculateIndex] = \Dystore\Api\Domain\Carts\Pipelines\Calculate::class;
        // }

        Config::set('lunar.cart.pipelines.cart', $cartPipelines);

        Config::set(
            'lunar.cart.validators.set_payment_option',
            [\Dystore\Api\Domain\Carts\Validation\PaymentOptionValidator::class],
        );

        Config::set(
            'lunar.cart.actions.set_payment_option',
            \Dystore\Api\Domain\Carts\Actions\SetPaymentOption::class,
        );

        Config::set(
            'lunar.cart.actions.unset_payment_option',
            \Dystore\Api\Domain\Carts\Actions\UnsetPaymentOption::class,
        );

        Config::set(
            'lunar.cart.actions.order_create',
            \Dystore\Api\Domain\Carts\Actions\CreateOrder::class,
        );

        $orderPipelines = Config::get('lunar.orders.pipelines.creation', []);

        // Swap fill order from cart pipeline
        $fillOrderFromCartIndex = array_search(\Lunar\Pipelines\Order\Creation\FillOrderFromCart::class, $orderPipelines);
        if (array_key_exists($fillOrderFromCartIndex, $orderPipelines)) {
            $orderPipelines[$fillOrderFromCartIndex] = \Dystore\Api\Domain\Orders\Pipelines\FillOrderFromCart::class;
        }

        // Push create payment line pipeline after create shipping line pipeline
        $createShippingLineIndex = array_search(\Lunar\Pipelines\Order\Creation\CreateShippingLine::class, $orderPipelines);
        if (array_key_exists($createShippingLineIndex, $orderPipelines)) {
            $orderPipelines = array_merge(
                array_slice($orderPipelines, 0, $createShippingLineIndex + 1),
                [\Dystore\Api\Domain\Orders\Pipelines\CreatePaymentLine::class],
                array_slice($orderPipelines, $createShippingLineIndex + 1),
            );
        }
        //
        // // NOTE: Workaround
        // // Swap create order lines pipeline
        // $createOrderLinesIndex = array_search(\Lunar\Pipelines\Order\Creation\CreateOrderLines::class, $orderPipelines);
        // if (array_key_exists($createOrderLinesIndex, $orderPipelines)) {
        //     $orderPipelines[$createOrderLinesIndex] = \Dystore\Api\Domain\Orders\Pipelines\CreateOrderLines::class;
        // }
        //
        // // NOTE: Workaround
        // // Swap create order addresses pipeline
        // $createOrderAddressesIndex = array_search(\Lunar\Pipelines\Order\Creation\CreateOrderAddresses::class, $orderPipelines);
        // if (array_key_exists($createOrderAddressesIndex, $orderPipelines)) {
        //     $orderPipelines[$createOrderAddressesIndex] = \Dystore\Api\Domain\Orders\Pipelines\CreateOrderAddresses::class;
        // }
        //
        // // NOTE: Workaround
        // // Swap create shipping line pipeline
        // $createShippingLineIndex = array_search(\Lunar\Pipelines\Order\Creation\CreateShippingLine::class, $orderPipelines);
        // if (array_key_exists($createShippingLineIndex, $orderPipelines)) {
        //     $orderPipelines[$createShippingLineIndex] = \Dystore\Api\Domain\Orders\Pipelines\CreateShippingLine::class;
        // }

        // Swap clean up order lines pipeline
        $cleanupOrderLinesIndex = array_search(\Lunar\Pipelines\Order\Creation\CleanUpOrderLines::class, $orderPipelines);
        if (array_key_exists($cleanupOrderLinesIndex, $orderPipelines)) {
            $orderPipelines[$cleanupOrderLinesIndex] = \Dystore\Api\Domain\Orders\Pipelines\CleanUpOrderLines::class;
        }

        Config::set('lunar.orders.pipelines.creation', $orderPipelines);
    }

    /**
     * Publish migrations.
     */
    protected function publishMigrations(): void
    {
        $this->publishes([
            "{$this->root}/database/migrations/" => $this->app->databasePath('migrations'),
        ], 'lunar-api.migrations');
    }

    /**
     * Bind controllers.
     */
    protected function bindControllers(): void
    {
        $controllers = [
            \Dystore\Api\Domain\Addresses\Contracts\AddressesController::class => \Dystore\Api\Domain\Addresses\Http\Controllers\AddressesController::class,
            \Dystore\Api\Domain\Brands\Contracts\BrandsController::class => \Dystore\Api\Domain\Brands\Http\Controllers\BrandsController::class,
            \Dystore\Api\Domain\CartAddresses\Contracts\CartAddressShippingOptionController::class => \Dystore\Api\Domain\CartAddresses\Http\Controllers\CartAddressShippingOptionController::class,
            \Dystore\Api\Domain\CartAddresses\Contracts\CartAddressesController::class => \Dystore\Api\Domain\CartAddresses\Http\Controllers\CartAddressesController::class,
            \Dystore\Api\Domain\CartAddresses\Contracts\ContinuousUpdateCartAddressController::class => \Dystore\Api\Domain\CartAddresses\Http\Controllers\ContinuousUpdateCartAddressController::class,
            \Dystore\Api\Domain\CartAddresses\Contracts\UpdateCartAddressCountryController::class => \Dystore\Api\Domain\CartAddresses\Http\Controllers\UpdateCartAddressCountryController::class,
            \Dystore\Api\Domain\CartLines\Contracts\CartLinesController::class => \Dystore\Api\Domain\CartLines\Http\Controllers\CartLinesController::class,
            \Dystore\Api\Domain\Carts\Contracts\CartCouponsController::class => \Dystore\Api\Domain\Carts\Http\Controllers\CartCouponsController::class,
            \Dystore\Api\Domain\Carts\Contracts\CartPaymentOptionController::class => \Dystore\Api\Domain\Carts\Http\Controllers\CartPaymentOptionController::class,
            \Dystore\Api\Domain\Carts\Contracts\CartsController::class => \Dystore\Api\Domain\Carts\Http\Controllers\CartsController::class,
            \Dystore\Api\Domain\Carts\Contracts\CheckoutCartController::class => \Dystore\Api\Domain\Carts\Http\Controllers\CheckoutCartController::class,
            \Dystore\Api\Domain\Carts\Contracts\ClearUserCartController::class => \Dystore\Api\Domain\Carts\Http\Controllers\ClearUserCartController::class,
            \Dystore\Api\Domain\Carts\Contracts\CreateEmptyCartAddressesController::class => \Dystore\Api\Domain\Carts\Http\Controllers\CreateEmptyCartAddressesController::class,
            \Dystore\Api\Domain\Carts\Contracts\ReadUserCartController::class => \Dystore\Api\Domain\Carts\Http\Controllers\ReadUserCartController::class,
            \Dystore\Api\Domain\Channels\Contracts\ChannelsController::class => \Dystore\Api\Domain\Channels\Http\Controllers\ChannelsController::class,
            \Dystore\Api\Domain\Collections\Contracts\CollectionsController::class => \Dystore\Api\Domain\Collections\Http\Controllers\CollectionsController::class,
            \Dystore\Api\Domain\Countries\Contracts\CountriesController::class => \Dystore\Api\Domain\Countries\Http\Controllers\CountriesController::class,
            \Dystore\Api\Domain\Currencies\Contracts\CurrenciesController::class => \Dystore\Api\Domain\Currencies\Http\Controllers\CurrenciesController::class,
            \Dystore\Api\Domain\Customers\Contracts\CustomersController::class => \Dystore\Api\Domain\Customers\Http\Controllers\CustomersController::class,
            \Dystore\Api\Domain\Media\Contracts\MediaController::class => \Dystore\Api\Domain\Media\Http\Controllers\MediaController::class,
            \Dystore\Api\Domain\Orders\Contracts\CheckOrderPaymentStatusController::class => \Dystore\Api\Domain\Orders\Http\Controllers\CheckOrderPaymentStatusController::class,
            \Dystore\Api\Domain\Orders\Contracts\CreatePaymentIntentController::class => \Dystore\Api\Domain\Orders\Http\Controllers\CreatePaymentIntentController::class,
            \Dystore\Api\Domain\Orders\Contracts\MarkOrderAwaitingPaymentController::class => \Dystore\Api\Domain\Orders\Http\Controllers\MarkOrderAwaitingPaymentController::class,
            \Dystore\Api\Domain\Orders\Contracts\MarkOrderPendingPaymentController::class => \Dystore\Api\Domain\Orders\Http\Controllers\MarkOrderPendingPaymentController::class,
            \Dystore\Api\Domain\Orders\Contracts\OrdersController::class => \Dystore\Api\Domain\Orders\Http\Controllers\OrdersController::class,
            \Dystore\Api\Domain\PaymentOptions\Contracts\PaymentOptionsController::class => \Dystore\Api\Domain\PaymentOptions\Http\Controllers\PaymentOptionsController::class,
            \Dystore\Api\Domain\Payments\Contracts\HandlePaymentWebhookController::class => \Dystore\Api\Domain\Payments\Http\Controllers\HandlePaymentWebhookController::class,
            \Dystore\Api\Domain\ProductOptionValues\Contracts\ProductOptionValuesController::class => \Dystore\Api\Domain\ProductOptionValues\Http\Controllers\ProductOptionValuesController::class,
            \Dystore\Api\Domain\ProductVariants\Contracts\ProductVariantsController::class => \Dystore\Api\Domain\ProductVariants\Http\Controllers\ProductVariantsController::class,
            \Dystore\Api\Domain\Products\Contracts\ProductsController::class => \Dystore\Api\Domain\Products\Http\Controllers\ProductsController::class,
            \Dystore\Api\Domain\ShippingOptions\Contracts\ShippingOptionsController::class => \Dystore\Api\Domain\ShippingOptions\Http\Controllers\ShippingOptionsController::class,
            \Dystore\Api\Domain\Tags\Contracts\TagsController::class => \Dystore\Api\Domain\Tags\Http\Controllers\TagsController::class,
            \Dystore\Api\Domain\Urls\Contracts\UrlsController::class => \Dystore\Api\Domain\Urls\Http\Controllers\UrlsController::class,
            \Dystore\Api\Domain\Users\Contracts\UsersController::class => \Dystore\Api\Domain\Users\Http\Controllers\UsersController::class,
            \Dystore\Api\Domain\Users\Contracts\ChangePasswordController::class => \Dystore\Api\Domain\Users\Http\Controllers\ChangePasswordController::class,
            \Dystore\Api\Domain\Auth\Contracts\AuthUserOrdersController::class => \Dystore\Api\Domain\Auth\Http\Controllers\AuthUserOrdersController::class,
            \Dystore\Api\Domain\Auth\Contracts\RegisterUserWithoutPasswordController::class => \Dystore\Api\Domain\Auth\Http\Controllers\RegisterUserWithoutPasswordController::class,
            \Dystore\Api\Domain\Auth\Contracts\AuthController::class => \Dystore\Api\Domain\Auth\Http\Controllers\AuthController::class,
            \Dystore\Api\Domain\Auth\Contracts\PasswordResetLinkController::class => \Dystore\Api\Domain\Auth\Http\Controllers\PasswordResetLinkController::class,
            \Dystore\Api\Domain\Auth\Contracts\NewPasswordController::class => \Dystore\Api\Domain\Auth\Http\Controllers\NewPasswordController::class,
        ];

        foreach ($controllers as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    /**
     * Register commands.
     */
    protected function registerCommands(): void
    {
        $this->commands([
            \Dystore\Api\Domain\ProductVariants\Commands\GenerateUrls::class,
        ]);
    }

    /**
     * Register events.
     */
    protected function registerEvents(): void
    {
        $events = [
            \Dystore\Api\Domain\Orders\Events\OrderPaymentFailed::class => [
                \Dystore\Api\Domain\Payments\Listeners\HandleFailedPayment::class,
            ],
            \Dystore\Api\Domain\Orders\Events\OrderPaymentCanceled::class => [
                \Dystore\Api\Domain\Payments\Listeners\HandleFailedPayment::class,
            ],
            \Illuminate\Auth\Events\Login::class => [
                \Dystore\Api\Domain\Auth\Listeners\CartSessionAuthListener::class,
            ],
        ];

        foreach ($events as $event => $listeners) {
            foreach ($listeners as $listener) {
                Event::listen($event, $listener);
            }
        }
    }

    /**
     * Register payment.
     */
    protected function registerPayments(): void
    {
        // Offline payments
        \Dystore\Api\Domain\Payments\PaymentAdapters\OfflinePaymentAdapter::register();
        \Dystore\Api\Domain\Payments\PaymentAdapters\BankTransferPaymentAdapter::register();
        \Dystore\Api\Domain\Payments\PaymentAdapters\CashOnDeliveryPaymentAdapter::register();

        \Lunar\Facades\Payments::extend(
            'offline',
            fn (Application $app) => $app->make(
                \Dystore\Api\Domain\Payments\PaymentTypes\OfflinePaymentType::class,
            ),
        );
    }

    /**
     * Register observers.
     */
    protected function registerObservers(): void
    {
        \Lunar\Models\Order::observe(\Dystore\Api\Domain\Orders\Observers\OrderObserver::class);
    }

    /**
     * Swap models.
     */
    protected function registerModels(): void
    {
        foreach (DomainConfigCollection::make()->getModelsForModelManifest() as $contract => $model) {
            ModelManifest::replace($contract, $model);
        }
    }

    /**
     * Register dynamic relations.
     */
    protected function registerDynamicRelations(): void
    {
        \Lunar\Models\ProductVariant::resolveRelationUsing('attributes', function ($model) {
            return $model
                ->hasMany(
                    \Lunar\Models\Attribute::modelClass(),
                    'attribute_type',
                    'attribute_type',
                );
        });

        \Lunar\Models\ProductVariant::resolveRelationUsing('urls', function ($model) {
            return $model
                ->morphMany(
                    \Lunar\Models\Url::modelClass(),
                    'element'
                );
        });

        \Lunar\Models\ProductVariant::resolveRelationUsing('defaultUrl', function ($model) {
            return $model
                ->morphOne(
                    \Lunar\Models\Url::modelClass(),
                    'element'
                )->whereDefault(true);
        });

        \Lunar\Models\ProductVariant::resolveRelationUsing('otherVariants', function ($model) {
            return $model
                ->hasMany(\Lunar\Models\ProductVariant::modelClass(), 'product_id', 'product_id')
                ->where($model->getRouteKeyName(), '!=', $model->getAttribute($model->getRouteKeyName()));
        });
    }

    /**
     * Bind models.
     */
    protected function bindModels(): void
    {
        $this->app->bind(
            \Dystore\Api\Domain\Carts\Contracts\CurrentSessionCart::class,
            function (Application $app): ?\Lunar\Models\Contracts\Cart {
                /** @var \Lunar\Managers\CartSessionManager $cartSession */
                $cartSession = $this->app->make(CartSessionInterface::class);

                return $cartSession->current();
            }
        );
    }

    /**
     * Register the application's policies.
     */
    public function registerPolicies(): void
    {
        DomainConfigCollection::make()
            ->getPolicies()
            ->each(
                fn (string $policy, string $model) => Gate::policy($model, $policy),
            );
    }
}
