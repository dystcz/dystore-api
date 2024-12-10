<?php

namespace Dystore\Api\Domain\Storefront\Managers;

use Illuminate\Auth\AuthManager;
use Illuminate\Session\SessionManager;
use Lunar\Managers\StorefrontSessionManager as LunarStorefrontSessionManager;
use Lunar\Models\Contracts\Country as CountryContract;

class StorefrontSessionManager extends LunarStorefrontSessionManager
{
    /**
     * The current country
     */
    protected ?CountryContract $country = null;

    /**
     * Initialise the manager
     *
     * @param protected SessionManager
     */
    public function __construct(
        protected SessionManager $sessionManager,
        protected AuthManager $authManager
    ) {
        parent::__construct($sessionManager, $authManager);
    }

    /**
     * {@inheritDoc}
     */
    public function forget(): void
    {
        $this->sessionManager->forget(
            $this->getSessionKey(),
        );

        $this
            ->resetCustomer()
            ->resetChannel()
            ->resetCustomerGroups();
    }

    public function resetCurrency(): self
    {
        $this->sessionManager->forget("{$this->getSessionKey()}_currency");

        $this->currency = null;

        return $this;
    }

    public function resetChannel(): self
    {
        $this->sessionManager->forget("{$this->getSessionKey()}_channel");

        $this->channel = null;

        return $this;
    }

    public function resetCustomer(): self
    {
        $this->sessionManager->forget("{$this->getSessionKey()}_customer");

        $this->customer = null;

        return $this;
    }
}
