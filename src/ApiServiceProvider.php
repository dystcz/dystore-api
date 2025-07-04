<?php

namespace Dystore\Api;

use Dystore\Api\Api as DystoreApi;
use Dystore\Api\Domain\Carts\Actions\CheckoutCart;
use Dystore\Api\Domain\Carts\Actions\CreateUserFromCart;
use Dystore\Api\Domain\Payments\Contracts\PaymentIntent as PaymentIntentContract;
use Dystore\Api\Domain\Payments\Data\PaymentIntent;
use Dystore\Api\Domain\Users\Actions\CreateUser;
use Dystore\Api\Domain\Users\Actions\RegisterUser;
use Dystore\Api\Facades\Api;
use Dystore\Api\Support\Config\Collections\DomainConfigCollection;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Router;
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
            'dystore',
        );

        $this->booting(function () {
            $this->registerPolicies();
        });

        // Register the main class to use with the facade.
        $this->app->singleton(
            'dystore',
            fn () => new DystoreApi,
        );

        $this->bindControllers();
        $this->bindModels();

        // Register payment adapters register.
        $this->app->singleton(
            Domain\Payments\PaymentAdapters\PaymentAdaptersRegister::class,
            fn () => new Domain\Payments\PaymentAdapters\PaymentAdaptersRegister,
        );

        // Register payment modifiers.
        $this->app->singleton(
            Domain\PaymentOptions\Modifiers\PaymentModifiers::class,
            fn (Application $app) => new Domain\PaymentOptions\Modifiers\PaymentModifiers,
        );

        // Register payment manifest.
        $this->app->singleton(
            Domain\PaymentOptions\Contracts\PaymentManifest::class,
            fn (Application $app) => $app->make(Domain\PaymentOptions\Manifests\PaymentManifest::class),
        );

        // Register storefront session manager.
        $this->app->singleton(
            \Lunar\Base\StorefrontSessionInterface::class,
            fn (Application $app) => $app->make(Domain\Storefront\Managers\StorefrontSessionManager::class),
        );

        $this->app->bind(
            PaymentIntentContract::class,
            PaymentIntent::class,
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
        $this->registerMiddleware();
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

    /**
     * Publish config files.
     */
    protected function publishConfig(): void
    {
        foreach ($this->configFiles as $configFile) {
            $this->publishes([
                "{$this->root}/config/{$configFile}.php" => config_path("dystore/{$configFile}.php"),
            ], 'dystore-api');
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
            "{$this->root}/lang" => $this->app->langPath('vendor/dystore-api'),
        ], 'dystore-api.translations');
    }

    /**
     * Register config files.
     */
    protected function registerConfig(): void
    {
        foreach ($this->configFiles as $configFile) {
            $this->mergeConfigFrom(
                "{$this->root}/config/{$configFile}.php",
                "dystore.{$configFile}",
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
                [Domain\Carts\Pipelines\ApplyPayment::class],
                array_slice($cartPipelines, $applyShippingIndex + 1),
            );
        }

        // Push calculate payment pipeline after calculate pipeline
        $calculateIndex = array_search(\Lunar\Pipelines\Cart\Calculate::class, $cartPipelines);

        if (array_key_exists($calculateIndex, $cartPipelines)) {
            $cartPipelines = array_merge(
                array_slice($cartPipelines, 0, $calculateIndex + 1),
                [Domain\Carts\Pipelines\CalculatePayment::class],
                array_slice($cartPipelines, $calculateIndex + 1),
            );
        }

        Config::set('lunar.cart.pipelines.cart', $cartPipelines);

        Config::set(
            'lunar.cart.validators.set_payment_option',
            [Domain\Carts\Validation\PaymentOptionValidator::class],
        );

        Config::set(
            'lunar.cart.actions.set_payment_option',
            Domain\Carts\Actions\SetPaymentOption::class,
        );

        Config::set(
            'lunar.cart.actions.unset_payment_option',
            Domain\Carts\Actions\UnsetPaymentOption::class,
        );

        Config::set(
            'lunar.cart.actions.order_create',
            Domain\Carts\Actions\CreateOrder::class,
        );

        $orderPipelines = Config::get('lunar.orders.pipelines.creation', []);

        // Swap fill order from cart pipeline
        $fillOrderFromCartIndex = array_search(\Lunar\Pipelines\Order\Creation\FillOrderFromCart::class, $orderPipelines);
        if (array_key_exists($fillOrderFromCartIndex, $orderPipelines)) {
            $orderPipelines[$fillOrderFromCartIndex] = Domain\Orders\Pipelines\FillOrderFromCart::class;
        }

        // Push create payment line pipeline after create shipping line pipeline
        $createShippingLineIndex = array_search(\Lunar\Pipelines\Order\Creation\CreateShippingLine::class, $orderPipelines);
        if (array_key_exists($createShippingLineIndex, $orderPipelines)) {
            $orderPipelines = array_merge(
                array_slice($orderPipelines, 0, $createShippingLineIndex + 1),
                [Domain\Orders\Pipelines\CreatePaymentLine::class],
                array_slice($orderPipelines, $createShippingLineIndex + 1),
            );
        }

        // Swap clean up order lines pipeline
        $cleanupOrderLinesIndex = array_search(\Lunar\Pipelines\Order\Creation\CleanUpOrderLines::class, $orderPipelines);
        if (array_key_exists($cleanupOrderLinesIndex, $orderPipelines)) {
            $orderPipelines[$cleanupOrderLinesIndex] = Domain\Orders\Pipelines\CleanUpOrderLines::class;
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
        ], 'dystore-api.migrations');
    }

    /**
     * Bind controllers.
     */
    protected function bindControllers(): void
    {
        $controllers = [
            Domain\Addresses\Contracts\AddressesController::class => Domain\Addresses\Http\Controllers\AddressesController::class,
            Domain\Auth\Contracts\AuthController::class => Domain\Auth\Http\Controllers\AuthController::class,
            Domain\Auth\Contracts\AuthUserOrdersController::class => Domain\Auth\Http\Controllers\AuthUserOrdersController::class,
            Domain\Auth\Contracts\NewPasswordController::class => Domain\Auth\Http\Controllers\NewPasswordController::class,
            Domain\Auth\Contracts\PasswordResetLinkController::class => Domain\Auth\Http\Controllers\PasswordResetLinkController::class,
            Domain\Auth\Contracts\RegisterUserWithoutPasswordController::class => Domain\Auth\Http\Controllers\RegisterUserWithoutPasswordController::class,
            Domain\Brands\Contracts\BrandsController::class => Domain\Brands\Http\Controllers\BrandsController::class,
            Domain\CartAddresses\Contracts\CartAddressShippingOptionController::class => Domain\CartAddresses\Http\Controllers\CartAddressShippingOptionController::class,
            Domain\CartAddresses\Contracts\CartAddressesController::class => Domain\CartAddresses\Http\Controllers\CartAddressesController::class,
            Domain\CartAddresses\Contracts\ContinuousUpdateCartAddressController::class => Domain\CartAddresses\Http\Controllers\ContinuousUpdateCartAddressController::class,
            Domain\CartAddresses\Contracts\UpdateCartAddressCountryController::class => Domain\CartAddresses\Http\Controllers\UpdateCartAddressCountryController::class,
            Domain\CartLines\Contracts\CartLinesController::class => Domain\CartLines\Http\Controllers\CartLinesController::class,
            Domain\Carts\Contracts\CartCouponsController::class => Domain\Carts\Http\Controllers\CartCouponsController::class,
            Domain\Carts\Contracts\CartPaymentOptionController::class => Domain\Carts\Http\Controllers\CartPaymentOptionController::class,
            Domain\Carts\Contracts\CartShippingOptionController::class => Domain\Carts\Http\Controllers\CartShippingOptionController::class,
            Domain\Carts\Contracts\CartsController::class => Domain\Carts\Http\Controllers\CartsController::class,
            Domain\Carts\Contracts\CheckoutCartController::class => Domain\Carts\Http\Controllers\CheckoutCartController::class,
            Domain\Carts\Contracts\ClearUserCartController::class => Domain\Carts\Http\Controllers\ClearUserCartController::class,
            Domain\Carts\Contracts\CreateEmptyCartAddressesController::class => Domain\Carts\Http\Controllers\CreateEmptyCartAddressesController::class,
            Domain\Carts\Contracts\ReadUserCartController::class => Domain\Carts\Http\Controllers\ReadUserCartController::class,
            Domain\Channels\Contracts\ChannelsController::class => Domain\Channels\Http\Controllers\ChannelsController::class,
            Domain\Collections\Contracts\CollectionsController::class => Domain\Collections\Http\Controllers\CollectionsController::class,
            Domain\Countries\Contracts\CountriesController::class => Domain\Countries\Http\Controllers\CountriesController::class,
            Domain\Currencies\Contracts\CurrenciesController::class => Domain\Currencies\Http\Controllers\CurrenciesController::class,
            Domain\CustomerGroups\Contracts\CustomerGroupsController::class => Domain\CustomerGroups\Http\Controllers\CustomerGroupsController::class,
            Domain\Customers\Contracts\CustomersController::class => Domain\Customers\Http\Controllers\CustomersController::class,
            Domain\Media\Contracts\MediaController::class => Domain\Media\Http\Controllers\MediaController::class,
            Domain\Orders\Contracts\CheckOrderPaymentStatusController::class => Domain\Orders\Http\Controllers\CheckOrderPaymentStatusController::class,
            Domain\Orders\Contracts\CreatePaymentIntentController::class => Domain\Orders\Http\Controllers\CreatePaymentIntentController::class,
            Domain\Orders\Contracts\MarkOrderAwaitingPaymentController::class => Domain\Orders\Http\Controllers\MarkOrderAwaitingPaymentController::class,
            Domain\Orders\Contracts\MarkOrderPendingPaymentController::class => Domain\Orders\Http\Controllers\MarkOrderPendingPaymentController::class,
            Domain\Orders\Contracts\OrdersController::class => Domain\Orders\Http\Controllers\OrdersController::class,
            Domain\PaymentOptions\Contracts\PaymentOptionsController::class => Domain\PaymentOptions\Http\Controllers\PaymentOptionsController::class,
            Domain\Payments\Contracts\HandlePaymentWebhookController::class => Domain\Payments\Http\Controllers\HandlePaymentWebhookController::class,
            Domain\ProductOptionValues\Contracts\ProductOptionValuesController::class => Domain\ProductOptionValues\Http\Controllers\ProductOptionValuesController::class,
            Domain\ProductVariants\Contracts\ProductVariantsController::class => Domain\ProductVariants\Http\Controllers\ProductVariantsController::class,
            Domain\Products\Contracts\ProductsController::class => Domain\Products\Http\Controllers\ProductsController::class,
            Domain\ShippingOptions\Contracts\ShippingOptionsController::class => Domain\ShippingOptions\Http\Controllers\ShippingOptionsController::class,
            Domain\Storefront\Contracts\StorefrontController::class => Domain\Storefront\Http\Controllers\StorefrontController::class,
            Domain\Tags\Contracts\TagsController::class => Domain\Tags\Http\Controllers\TagsController::class,
            Domain\Urls\Contracts\UrlsController::class => Domain\Urls\Http\Controllers\UrlsController::class,
            Domain\Users\Contracts\ChangePasswordController::class => Domain\Users\Http\Controllers\ChangePasswordController::class,
            Domain\Users\Contracts\UsersController::class => Domain\Users\Http\Controllers\UsersController::class,
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
            Domain\ProductVariants\Commands\GenerateUrls::class,
        ]);
    }

    /**
     * Register events.
     */
    protected function registerEvents(): void
    {
        $events = [
            Domain\Orders\Events\OrderPaymentFailed::class => [
                Domain\Payments\Listeners\HandleFailedPayment::class,
            ],
            Domain\Orders\Events\OrderPaymentCanceled::class => [
                Domain\Payments\Listeners\HandleFailedPayment::class,
            ],
            \Illuminate\Auth\Events\Login::class => [
                Domain\Auth\Listeners\CartSessionAuthListener::class,
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
        Domain\Payments\PaymentAdapters\OfflinePaymentAdapter::register();
        Domain\Payments\PaymentAdapters\BankTransferPaymentAdapter::register();
        Domain\Payments\PaymentAdapters\CashOnDeliveryPaymentAdapter::register();

        \Lunar\Facades\Payments::extend(
            'offline',
            fn (Application $app) => $app->make(
                Domain\Payments\PaymentTypes\OfflinePaymentType::class,
            ),
        );
    }

    /**
     * Register observers.
     */
    protected function registerObservers(): void
    {
        \Lunar\Models\Order::observe(Domain\Orders\Observers\OrderObserver::class);
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

    protected function registerMiddleware(): void
    {
        /** @var Router $router */
        $router = $this->app['router'];

        $router->aliasMiddleware('api-pricing', \Dystore\Api\Domain\Prices\Http\Middleware\SetApiPricing::class);
        $router->aliasMiddleware('api-headers', \Dystore\Api\Routing\Middleware\SetApiHeaders::class);

        /** @var \Illuminate\Foundation\Http\Kernel $kernel */
        $kernel = $this->app->make(\Illuminate\Contracts\Http\Kernel::class);

        $kernel->addToMiddlewarePriorityBefore(
            before: \Dystore\Api\Routing\Middleware\SetApiHeaders::class,
            middleware: \Illuminate\Auth\Middleware\Authenticate::class
        );
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
            Domain\Carts\Contracts\CurrentSessionCart::class,
            function (Application $app): ?\Lunar\Models\Contracts\Cart {
                /** @var \Lunar\Managers\CartSessionManager $cartSession */
                $cartSession = $this->app->make(CartSessionInterface::class);

                return $cartSession->current();
            }
        );
    }
}
