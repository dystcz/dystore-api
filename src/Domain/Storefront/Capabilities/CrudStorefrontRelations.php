<?php

namespace Dystore\Api\Domain\Storefront\Capabilities;

use Dystore\Api\Domain\Storefront\Entities\Storefront;
use Dystore\Api\Domain\Storefront\Entities\StorefrontStorage;
use Illuminate\Support\Collection;
use LaravelJsonApi\NonEloquent\Capabilities\CrudRelations;
use Lunar\Models\Contracts\Channel as ChannelContract;
use Lunar\Models\Contracts\Currency as CurrencyContract;
use Lunar\Models\Contracts\Customer as CustomerContract;

class CrudStorefrontRelations extends CrudRelations
{
    private StorefrontStorage $storage;

    public function __construct(StorefrontStorage $storage)
    {
        parent::__construct();
        $this->storage = $storage;
    }

    public function getCustomer(Storefront $storefront): ?CustomerContract
    {
        return $storefront->storefrontSession->getCustomer();
    }

    public function getChannel(Storefront $storefront): ?ChannelContract
    {
        return $storefront->storefrontSession->getChannel();
    }

    public function getCurrency(Storefront $storefront): ?CurrencyContract
    {
        return $storefront->storefrontSession->getCurrency();
    }

    public function getCustomerGroups(Storefront $storefront): iterable
    {
        return $storefront->storefrontSession->getCustomerGroups();
    }

    public function setCustomer(Storefront $storefront, ?CustomerContract $customer): void
    {
        $storefront->storefrontSession->setCustomer($customer);
    }

    public function setChannel(Storefront $storefront, ?ChannelContract $channel): void
    {
        $storefront->storefrontSession->setChannel($channel);
    }

    public function setCurrency(Storefront $storefront, ?CurrencyContract $currency): void
    {
        $storefront->storefrontSession->setCurrency($currency);
    }

    public function setCustomerGroups(Storefront $storefront, array $customerGroups): void
    {
        $storefront->storefrontSession->setCustomerGroups(Collection::make($customerGroups));
    }
}
