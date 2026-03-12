<?php

use Dystore\Api\Domain\Addresses\Http\Routing\AddressRouteGroup;
use Dystore\Api\Domain\Addresses\JsonApi\V1\AddressCollectionQuery;
use Dystore\Api\Domain\Addresses\JsonApi\V1\AddressQuery;
use Dystore\Api\Domain\Addresses\JsonApi\V1\AddressResource;
use Dystore\Api\Domain\Addresses\JsonApi\V1\AddressSchema;
use Dystore\Api\Domain\Addresses\Policies\AddressPolicy;
use Dystore\Api\Domain\AttributeGroups\JsonApi\V1\AttributeGroupCollectionQuery;
use Dystore\Api\Domain\AttributeGroups\JsonApi\V1\AttributeGroupQuery;
use Dystore\Api\Domain\AttributeGroups\JsonApi\V1\AttributeGroupResource;
use Dystore\Api\Domain\AttributeGroups\JsonApi\V1\AttributeGroupSchema;
use Dystore\Api\Domain\AttributeGroups\Policies\AttributeGroupPolicy;
use Dystore\Api\Domain\Attributes\JsonApi\V1\AttributeCollectionQuery;
use Dystore\Api\Domain\Attributes\JsonApi\V1\AttributeQuery;
use Dystore\Api\Domain\Attributes\JsonApi\V1\AttributeResource;
use Dystore\Api\Domain\Attributes\JsonApi\V1\AttributeSchema;
use Dystore\Api\Domain\Attributes\Policies\AttributePolicy;
use Dystore\Api\Domain\Auth\Http\Routing\AuthRouteGroup;
use Dystore\Api\Domain\Auth\JsonApi\V1\AuthSchema;
use Dystore\Api\Domain\Auth\Notifications\ResetPassword;
use Dystore\Api\Domain\Brands\Http\Routing\BrandRouteGroup;
use Dystore\Api\Domain\Brands\JsonApi\V1\BrandCollectionQuery;
use Dystore\Api\Domain\Brands\JsonApi\V1\BrandQuery;
use Dystore\Api\Domain\Brands\JsonApi\V1\BrandResource;
use Dystore\Api\Domain\Brands\JsonApi\V1\BrandSchema;
use Dystore\Api\Domain\Brands\Policies\BrandPolicy;
use Dystore\Api\Domain\CartAddresses\Http\Routing\CartAddressRouteGroup;
use Dystore\Api\Domain\CartAddresses\JsonApi\V1\CartAddressCollectionQuery;
use Dystore\Api\Domain\CartAddresses\JsonApi\V1\CartAddressQuery;
use Dystore\Api\Domain\CartAddresses\JsonApi\V1\CartAddressResource;
use Dystore\Api\Domain\CartAddresses\JsonApi\V1\CartAddressSchema;
use Dystore\Api\Domain\CartAddresses\Policies\CartAddressPolicy;
use Dystore\Api\Domain\CartLines\Http\Routing\CartLineRouteGroup;
use Dystore\Api\Domain\CartLines\JsonApi\V1\CartLineCollectionQuery;
use Dystore\Api\Domain\CartLines\JsonApi\V1\CartLineQuery;
use Dystore\Api\Domain\CartLines\JsonApi\V1\CartLineResource;
use Dystore\Api\Domain\CartLines\JsonApi\V1\CartLineSchema;
use Dystore\Api\Domain\CartLines\Policies\CartLinePolicy;
use Dystore\Api\Domain\Carts\Http\Routing\CartRouteGroup;
use Dystore\Api\Domain\Carts\JsonApi\V1\CartCollectionQuery;
use Dystore\Api\Domain\Carts\JsonApi\V1\CartQuery;
use Dystore\Api\Domain\Carts\JsonApi\V1\CartResource;
use Dystore\Api\Domain\Carts\JsonApi\V1\CartSchema;
use Dystore\Api\Domain\Carts\Policies\CartPolicy;
use Dystore\Api\Domain\Channels\Http\Routing\ChannelRouteGroup;
use Dystore\Api\Domain\Channels\JsonApi\V1\ChannelCollectionQuery;
use Dystore\Api\Domain\Channels\JsonApi\V1\ChannelQuery;
use Dystore\Api\Domain\Channels\JsonApi\V1\ChannelResource;
use Dystore\Api\Domain\Channels\JsonApi\V1\ChannelSchema;
use Dystore\Api\Domain\Channels\Policies\ChannelPolicy;
use Dystore\Api\Domain\CollectionGroups\JsonApi\V1\CollectionGroupCollectionQuery;
use Dystore\Api\Domain\CollectionGroups\JsonApi\V1\CollectionGroupQuery;
use Dystore\Api\Domain\CollectionGroups\JsonApi\V1\CollectionGroupResource;
use Dystore\Api\Domain\CollectionGroups\JsonApi\V1\CollectionGroupSchema;
use Dystore\Api\Domain\CollectionGroups\Policies\CollectionGroupPolicy;
use Dystore\Api\Domain\Collections\Http\Routing\CollectionRouteGroup;
use Dystore\Api\Domain\Collections\JsonApi\V1\CollectionCollectionQuery;
use Dystore\Api\Domain\Collections\JsonApi\V1\CollectionQuery;
use Dystore\Api\Domain\Collections\JsonApi\V1\CollectionResource;
use Dystore\Api\Domain\Collections\JsonApi\V1\CollectionSchema;
use Dystore\Api\Domain\Collections\Policies\CollectionPolicy;
use Dystore\Api\Domain\Countries\Http\Routing\CountryRouteGroup;
use Dystore\Api\Domain\Countries\JsonApi\V1\CountryCollectionQuery;
use Dystore\Api\Domain\Countries\JsonApi\V1\CountryQuery;
use Dystore\Api\Domain\Countries\JsonApi\V1\CountryResource;
use Dystore\Api\Domain\Countries\JsonApi\V1\CountrySchema;
use Dystore\Api\Domain\Countries\Policies\CountryPolicy;
use Dystore\Api\Domain\Currencies\Http\Routing\CurrencyRouteGroup;
use Dystore\Api\Domain\Currencies\JsonApi\V1\CurrencyCollectionQuery;
use Dystore\Api\Domain\Currencies\JsonApi\V1\CurrencyQuery;
use Dystore\Api\Domain\Currencies\JsonApi\V1\CurrencyResource;
use Dystore\Api\Domain\Currencies\JsonApi\V1\CurrencySchema;
use Dystore\Api\Domain\Currencies\Policies\CurrencyPolicy;
use Dystore\Api\Domain\CustomerGroups\Http\Routing\CustomerGroupRouteGroup;
use Dystore\Api\Domain\CustomerGroups\JsonApi\V1\CustomerGroupCollectionQuery;
use Dystore\Api\Domain\CustomerGroups\JsonApi\V1\CustomerGroupQuery;
use Dystore\Api\Domain\CustomerGroups\JsonApi\V1\CustomerGroupResource;
use Dystore\Api\Domain\CustomerGroups\JsonApi\V1\CustomerGroupSchema;
use Dystore\Api\Domain\CustomerGroups\Policies\CustomerGroupPolicy;
use Dystore\Api\Domain\Customers\Http\Routing\CustomerRouteGroup;
use Dystore\Api\Domain\Customers\JsonApi\V1\CustomerCollectionQuery;
use Dystore\Api\Domain\Customers\JsonApi\V1\CustomerQuery;
use Dystore\Api\Domain\Customers\JsonApi\V1\CustomerResource;
use Dystore\Api\Domain\Customers\JsonApi\V1\CustomerSchema;
use Dystore\Api\Domain\Customers\Policies\CustomerPolicy;
use Dystore\Api\Domain\Media\Http\Routing\MediaRouteGroup;
use Dystore\Api\Domain\Media\JsonApi\V1\MediaCollectionQuery;
use Dystore\Api\Domain\Media\JsonApi\V1\MediaQuery;
use Dystore\Api\Domain\Media\JsonApi\V1\MediaResource;
use Dystore\Api\Domain\Media\JsonApi\V1\MediaSchema;
use Dystore\Api\Domain\Media\Policies\MediaPolicy;
use Dystore\Api\Domain\OrderAddresses\JsonApi\V1\OrderAddressCollectionQuery;
use Dystore\Api\Domain\OrderAddresses\JsonApi\V1\OrderAddressQuery;
use Dystore\Api\Domain\OrderAddresses\JsonApi\V1\OrderAddressResource;
use Dystore\Api\Domain\OrderAddresses\JsonApi\V1\OrderAddressSchema;
use Dystore\Api\Domain\OrderAddresses\Policies\OrderAddressPolicy;
use Dystore\Api\Domain\OrderLines\JsonApi\V1\OrderLineCollectionQuery;
use Dystore\Api\Domain\OrderLines\JsonApi\V1\OrderLineQuery;
use Dystore\Api\Domain\OrderLines\JsonApi\V1\OrderLineResource;
use Dystore\Api\Domain\OrderLines\JsonApi\V1\OrderLineSchema;
use Dystore\Api\Domain\OrderLines\Policies\OrderLinePolicy;
use Dystore\Api\Domain\Orders\Http\Routing\OrderRouteGroup;
use Dystore\Api\Domain\Orders\JsonApi\V1\OrderCollectionQuery;
use Dystore\Api\Domain\Orders\JsonApi\V1\OrderQuery;
use Dystore\Api\Domain\Orders\JsonApi\V1\OrderResource;
use Dystore\Api\Domain\Orders\JsonApi\V1\OrderSchema;
use Dystore\Api\Domain\Orders\Policies\OrderPolicy;
use Dystore\Api\Domain\PaymentOptions\Entities\PaymentOption;
use Dystore\Api\Domain\PaymentOptions\Http\Routing\PaymentOptionRouteGroup;
use Dystore\Api\Domain\PaymentOptions\JsonApi\V1\PaymentOptionCollectionQuery;
use Dystore\Api\Domain\PaymentOptions\JsonApi\V1\PaymentOptionQuery;
use Dystore\Api\Domain\PaymentOptions\JsonApi\V1\PaymentOptionResource;
use Dystore\Api\Domain\PaymentOptions\JsonApi\V1\PaymentOptionSchema;
use Dystore\Api\Domain\Prices\JsonApi\V1\PriceCollectionQuery;
use Dystore\Api\Domain\Prices\JsonApi\V1\PriceQuery;
use Dystore\Api\Domain\Prices\JsonApi\V1\PriceResource;
use Dystore\Api\Domain\Prices\JsonApi\V1\PriceSchema;
use Dystore\Api\Domain\Prices\Policies\PricePolicy;
use Dystore\Api\Domain\ProductAssociations\JsonApi\V1\ProductAssociationCollectionQuery;
use Dystore\Api\Domain\ProductAssociations\JsonApi\V1\ProductAssociationQuery;
use Dystore\Api\Domain\ProductAssociations\JsonApi\V1\ProductAssociationResource;
use Dystore\Api\Domain\ProductAssociations\JsonApi\V1\ProductAssociationSchema;
use Dystore\Api\Domain\ProductAssociations\Policies\ProductAssociationPolicy;
use Dystore\Api\Domain\ProductOptions\JsonApi\V1\ProductOptionCollectionQuery;
use Dystore\Api\Domain\ProductOptions\JsonApi\V1\ProductOptionQuery;
use Dystore\Api\Domain\ProductOptions\JsonApi\V1\ProductOptionResource;
use Dystore\Api\Domain\ProductOptions\JsonApi\V1\ProductOptionSchema;
use Dystore\Api\Domain\ProductOptions\Policies\ProductOptionPolicy;
use Dystore\Api\Domain\ProductOptionValues\Http\Routing\ProductOptionValueRouteGroup;
use Dystore\Api\Domain\ProductOptionValues\JsonApi\V1\ProductOptionValueCollectionQuery;
use Dystore\Api\Domain\ProductOptionValues\JsonApi\V1\ProductOptionValueQuery;
use Dystore\Api\Domain\ProductOptionValues\JsonApi\V1\ProductOptionValueResource;
use Dystore\Api\Domain\ProductOptionValues\JsonApi\V1\ProductOptionValueSchema;
use Dystore\Api\Domain\ProductOptionValues\Policies\ProductOptionValuePolicy;
use Dystore\Api\Domain\Products\Http\Routing\ProductRouteGroup;
use Dystore\Api\Domain\Products\JsonApi\V1\ProductCollectionQuery;
use Dystore\Api\Domain\Products\JsonApi\V1\ProductQuery;
use Dystore\Api\Domain\Products\JsonApi\V1\ProductResource;
use Dystore\Api\Domain\Products\JsonApi\V1\ProductSchema;
use Dystore\Api\Domain\Products\Policies\ProductPolicy;
use Dystore\Api\Domain\ProductTypes\JsonApi\V1\ProductTypeCollectionQuery;
use Dystore\Api\Domain\ProductTypes\JsonApi\V1\ProductTypeQuery;
use Dystore\Api\Domain\ProductTypes\JsonApi\V1\ProductTypeResource;
use Dystore\Api\Domain\ProductTypes\JsonApi\V1\ProductTypeSchema;
use Dystore\Api\Domain\ProductTypes\Policies\ProductTypePolicy;
use Dystore\Api\Domain\ProductVariants\Http\Routing\ProductVariantRouteGroup;
use Dystore\Api\Domain\ProductVariants\JsonApi\V1\ProductVariantCollectionQuery;
use Dystore\Api\Domain\ProductVariants\JsonApi\V1\ProductVariantQuery;
use Dystore\Api\Domain\ProductVariants\JsonApi\V1\ProductVariantResource;
use Dystore\Api\Domain\ProductVariants\JsonApi\V1\ProductVariantSchema;
use Dystore\Api\Domain\ProductVariants\Policies\ProductVariantPolicy;
use Dystore\Api\Domain\ShippingOptions\Entities\ShippingOption;
use Dystore\Api\Domain\ShippingOptions\Http\Routing\ShippingOptionRouteGroup;
use Dystore\Api\Domain\ShippingOptions\JsonApi\V1\ShippingOptionCollectionQuery;
use Dystore\Api\Domain\ShippingOptions\JsonApi\V1\ShippingOptionQuery;
use Dystore\Api\Domain\ShippingOptions\JsonApi\V1\ShippingOptionResource;
use Dystore\Api\Domain\ShippingOptions\JsonApi\V1\ShippingOptionSchema;
use Dystore\Api\Domain\Storefront\Http\Routing\StorefrontRouteGroup;
use Dystore\Api\Domain\Storefront\JsonApi\V1\StorefrontSchema;
use Dystore\Api\Domain\Tags\Http\Routing\TagRouteGroup;
use Dystore\Api\Domain\Tags\JsonApi\V1\TagCollectionQuery;
use Dystore\Api\Domain\Tags\JsonApi\V1\TagQuery;
use Dystore\Api\Domain\Tags\JsonApi\V1\TagResource;
use Dystore\Api\Domain\Tags\JsonApi\V1\TagSchema;
use Dystore\Api\Domain\Tags\Policies\TagPolicy;
use Dystore\Api\Domain\TaxZones\JsonApi\V1\TaxZoneCollectionQuery;
use Dystore\Api\Domain\TaxZones\JsonApi\V1\TaxZoneQuery;
use Dystore\Api\Domain\TaxZones\JsonApi\V1\TaxZoneResource;
use Dystore\Api\Domain\TaxZones\JsonApi\V1\TaxZoneSchema;
use Dystore\Api\Domain\TaxZones\Policies\TaxZonePolicy;
use Dystore\Api\Domain\Transactions\JsonApi\V1\TransactionCollectionQuery;
use Dystore\Api\Domain\Transactions\JsonApi\V1\TransactionQuery;
use Dystore\Api\Domain\Transactions\JsonApi\V1\TransactionResource;
use Dystore\Api\Domain\Transactions\JsonApi\V1\TransactionSchema;
use Dystore\Api\Domain\Transactions\Policies\TransactionPolicy;
use Dystore\Api\Domain\Urls\Http\Routing\UrlRouteGroup;
use Dystore\Api\Domain\Urls\JsonApi\V1\UrlCollectionQuery;
use Dystore\Api\Domain\Urls\JsonApi\V1\UrlQuery;
use Dystore\Api\Domain\Urls\JsonApi\V1\UrlResource;
use Dystore\Api\Domain\Urls\JsonApi\V1\UrlSchema;
use Dystore\Api\Domain\Urls\Policies\UrlPolicy;
use Dystore\Api\Domain\Users\Contracts\User;
use Dystore\Api\Domain\Users\Http\Routing\UserRouteGroup;
use Dystore\Api\Domain\Users\JsonApi\V1\UserCollectionQuery;
use Dystore\Api\Domain\Users\JsonApi\V1\UserQuery;
use Dystore\Api\Domain\Users\JsonApi\V1\UserResource;
use Dystore\Api\Domain\Users\JsonApi\V1\UserSchema;
use Dystore\Api\Domain\Users\Policies\UserPolicy;
use Dystore\Api\Support\Models\Actions\SchemaType;
use Illuminate\Auth\Notifications\VerifyEmail;
use Lunar\Models\Contracts\Address;
use Lunar\Models\Contracts\Attribute;
use Lunar\Models\Contracts\AttributeGroup;
use Lunar\Models\Contracts\Brand;
use Lunar\Models\Contracts\Cart;
use Lunar\Models\Contracts\CartAddress;
use Lunar\Models\Contracts\CartLine;
use Lunar\Models\Contracts\Channel;
use Lunar\Models\Contracts\Collection;
use Lunar\Models\Contracts\CollectionGroup;
use Lunar\Models\Contracts\Country;
use Lunar\Models\Contracts\Currency;
use Lunar\Models\Contracts\Customer;
use Lunar\Models\Contracts\CustomerGroup;
use Lunar\Models\Contracts\Order;
use Lunar\Models\Contracts\OrderAddress;
use Lunar\Models\Contracts\OrderLine;
use Lunar\Models\Contracts\Price;
use Lunar\Models\Contracts\Product;
use Lunar\Models\Contracts\ProductAssociation;
use Lunar\Models\Contracts\ProductOption;
use Lunar\Models\Contracts\ProductOptionValue;
use Lunar\Models\Contracts\ProductType;
use Lunar\Models\Contracts\ProductVariant;
use Lunar\Models\Contracts\Tag;
use Lunar\Models\Contracts\TaxZone;
use Lunar\Models\Contracts\Transaction;
use Lunar\Models\Contracts\Url;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/*
 * Lunar API domains configuration
 */
return [
    'auth' => [
        'schema' => AuthSchema::class,
        'routes' => AuthRouteGroup::class,
        'notifications' => [
            'reset_password' => ResetPassword::class,
            'verify_email' => VerifyEmail::class,
        ],
    ],

    'storefronts' => [
        'schema' => StorefrontSchema::class,
        'routes' => StorefrontRouteGroup::class,
    ],

    SchemaType::get(Address::class) => [
        'model' => Dystore\Api\Domain\Addresses\Models\Address::class,
        'model_contract' => Address::class,
        'policy' => AddressPolicy::class,
        'schema' => AddressSchema::class,
        'resource' => AddressResource::class,
        'query' => AddressQuery::class,
        'collection_query' => AddressCollectionQuery::class,
        'routes' => AddressRouteGroup::class,
    ],

    SchemaType::get(Attribute::class) => [
        'model' => Dystore\Api\Domain\Attributes\Models\Attribute::class,
        'model_contract' => Attribute::class,
        'policy' => AttributePolicy::class,
        'schema' => AttributeSchema::class,
        'resource' => AttributeResource::class,
        'query' => AttributeQuery::class,
        'collection_query' => AttributeCollectionQuery::class,
        'routes' => null,
    ],

    SchemaType::get(AttributeGroup::class) => [
        'model' => Dystore\Api\Domain\AttributeGroups\Models\AttributeGroup::class,
        'model_contract' => AttributeGroup::class,
        'policy' => AttributeGroupPolicy::class,
        'schema' => AttributeGroupSchema::class,
        'resource' => AttributeGroupResource::class,
        'query' => AttributeGroupQuery::class,
        'collection_query' => AttributeGroupCollectionQuery::class,
        'routes' => null,
    ],

    SchemaType::get(ProductAssociation::class) => [
        'model' => Dystore\Api\Domain\ProductAssociations\Models\ProductAssociation::class,
        'model_contract' => ProductAssociation::class,
        'policy' => ProductAssociationPolicy::class,
        'schema' => ProductAssociationSchema::class,
        'resource' => ProductAssociationResource::class,
        'query' => ProductAssociationQuery::class,
        'collection_query' => ProductAssociationCollectionQuery::class,
        'routes' => null,
    ],

    SchemaType::get(Brand::class) => [
        'model' => Dystore\Api\Domain\Brands\Models\Brand::class,
        'model_contract' => Brand::class,
        'policy' => BrandPolicy::class,
        'schema' => BrandSchema::class,
        'resource' => BrandResource::class,
        'query' => BrandQuery::class,
        'collection_query' => BrandCollectionQuery::class,
        'routes' => BrandRouteGroup::class,
    ],

    SchemaType::get(CartAddress::class) => [
        'model' => Dystore\Api\Domain\CartAddresses\Models\CartAddress::class,
        'model_contract' => CartAddress::class,
        'policy' => CartAddressPolicy::class,
        'schema' => CartAddressSchema::class,
        'resource' => CartAddressResource::class,
        'query' => CartAddressQuery::class,
        'collection_query' => CartAddressCollectionQuery::class,
        'routes' => CartAddressRouteGroup::class,
    ],

    SchemaType::get(CartLine::class) => [
        'model' => Dystore\Api\Domain\CartLines\Models\CartLine::class,
        'model_contract' => CartLine::class,
        'policy' => CartLinePolicy::class,
        'schema' => CartLineSchema::class,
        'resource' => CartLineResource::class,
        'query' => CartLineQuery::class,
        'collection_query' => CartLineCollectionQuery::class,
        'routes' => CartLineRouteGroup::class,
    ],

    SchemaType::get(Cart::class) => [
        'model' => Dystore\Api\Domain\Carts\Models\Cart::class,
        'model_contract' => Cart::class,
        'policy' => CartPolicy::class,
        'schema' => CartSchema::class,
        'resource' => CartResource::class,
        'query' => CartQuery::class,
        'collection_query' => CartCollectionQuery::class,
        'routes' => CartRouteGroup::class,
    ],

    SchemaType::get(Channel::class) => [
        'model' => Dystore\Api\Domain\Channels\Models\Channel::class,
        'model_contract' => Channel::class,
        'policy' => ChannelPolicy::class,
        'schema' => ChannelSchema::class,
        'resource' => ChannelResource::class,
        'query' => ChannelQuery::class,
        'collection_query' => ChannelCollectionQuery::class,
        'routes' => ChannelRouteGroup::class,
    ],

    SchemaType::get(Collection::class) => [
        'model' => Dystore\Api\Domain\Collections\Models\Collection::class,
        'model_contract' => Collection::class,
        'policy' => CollectionPolicy::class,
        'schema' => CollectionSchema::class,
        'resource' => CollectionResource::class,
        'query' => CollectionQuery::class,
        'collection_query' => CollectionCollectionQuery::class,
        'routes' => CollectionRouteGroup::class,
    ],

    SchemaType::get(CollectionGroup::class) => [
        'model' => Dystore\Api\Domain\CollectionGroups\Models\CollectionGroup::class,
        'model_contract' => CollectionGroup::class,
        'policy' => CollectionGroupPolicy::class,
        'schema' => CollectionGroupSchema::class,
        'resource' => CollectionGroupResource::class,
        'query' => CollectionGroupQuery::class,
        'collection_query' => CollectionGroupCollectionQuery::class,
        'routes' => null,
    ],

    SchemaType::get(Country::class) => [
        'model' => Dystore\Api\Domain\Countries\Models\Country::class,
        'model_contract' => Country::class,
        'policy' => CountryPolicy::class,
        'schema' => CountrySchema::class,
        'resource' => CountryResource::class,
        'query' => CountryQuery::class,
        'collection_query' => CountryCollectionQuery::class,
        'routes' => CountryRouteGroup::class,
    ],

    SchemaType::get(Currency::class) => [
        'model' => Dystore\Api\Domain\Currencies\Models\Currency::class,
        'model_contract' => Currency::class,
        'policy' => CurrencyPolicy::class,
        'schema' => CurrencySchema::class,
        'resource' => CurrencyResource::class,
        'query' => CurrencyQuery::class,
        'collection_query' => CurrencyCollectionQuery::class,
        'routes' => CurrencyRouteGroup::class,
    ],

    SchemaType::get(Customer::class) => [
        'model' => Dystore\Api\Domain\Customers\Models\Customer::class,
        'model_contract' => Customer::class,
        'policy' => CustomerPolicy::class,
        'schema' => CustomerSchema::class,
        'resource' => CustomerResource::class,
        'query' => CustomerQuery::class,
        'collection_query' => CustomerCollectionQuery::class,
        'routes' => CustomerRouteGroup::class,
    ],

    SchemaType::get(CustomerGroup::class) => [
        'model' => Dystore\Api\Domain\CustomerGroups\Models\CustomerGroup::class,
        'model_contract' => CustomerGroup::class,
        'policy' => CustomerGroupPolicy::class,
        'schema' => CustomerGroupSchema::class,
        'resource' => CustomerGroupResource::class,
        'query' => CustomerGroupQuery::class,
        'collection_query' => CustomerGroupCollectionQuery::class,
        'routes' => CustomerGroupRouteGroup::class,
    ],

    // 'discounts' => [
    //     'model' => Dystore\Api\Domain\Discounts\Models\Discount::class,
    //     'model_contract' => Lunar\Models\Contracts\Discount::class,
    //     'policy' => Dystore\Api\Domain\Discounts\Policies\DiscountPolicy::class,
    //     'schema' => Dystore\Api\Domain\Discounts\JsonApi\V1\DiscountSchema::class,
    //     'resource' => Dystore\Api\Domain\Discounts\JsonApi\V1\DiscountResource::class,
    //     'query' => Dystore\Api\Domain\Discounts\JsonApi\V1\DiscountQuery::class,
    //     'collection_query' => Dystore\Api\Domain\Discounts\JsonApi\V1\DiscountCollectionQuery::class,
    //     'routes' => Dystore\Api\Domain\Discounts\Http\Routing\DiscountRouteGroup::class,
    //
    // ],

    SchemaType::get(Media::class) => [
        'model' => Media::class,
        'model_contract' => null,
        'policy' => MediaPolicy::class,
        'schema' => MediaSchema::class,
        'resource' => MediaResource::class,
        'query' => MediaQuery::class,
        'collection_query' => MediaCollectionQuery::class,
        'routes' => MediaRouteGroup::class,
    ],

    SchemaType::get(Order::class) => [
        'model' => Dystore\Api\Domain\Orders\Models\Order::class,
        'model_contract' => Order::class,
        'policy' => OrderPolicy::class,
        'schema' => OrderSchema::class,
        'resource' => OrderResource::class,
        'query' => OrderQuery::class,
        'collection_query' => OrderCollectionQuery::class,
        'routes' => OrderRouteGroup::class,
    ],

    SchemaType::get(OrderAddress::class) => [
        'model' => Dystore\Api\Domain\OrderAddresses\Models\OrderAddress::class,
        'model_contract' => OrderAddress::class,
        'policy' => OrderAddressPolicy::class,
        'schema' => OrderAddressSchema::class,
        'resource' => OrderAddressResource::class,
        'query' => OrderAddressQuery::class,
        'collection_query' => OrderAddressCollectionQuery::class,
        'routes' => null,
    ],

    SchemaType::get(OrderLine::class) => [
        'model' => Dystore\Api\Domain\OrderLines\Models\OrderLine::class,
        'model_contract' => OrderLine::class,
        'policy' => OrderLinePolicy::class,
        'schema' => OrderLineSchema::class,
        'resource' => OrderLineResource::class,
        'query' => OrderLineQuery::class,
        'collection_query' => OrderLineCollectionQuery::class,
        'routes' => null,
    ],

    SchemaType::get(PaymentOption::class) => [
        'model' => null,
        'model_contract' => null,
        'policy' => null,
        'schema' => PaymentOptionSchema::class,
        'resource' => PaymentOptionResource::class,
        'query' => PaymentOptionQuery::class,
        'collection_query' => PaymentOptionCollectionQuery::class,
        'routes' => PaymentOptionRouteGroup::class,
    ],

    SchemaType::get(Price::class) => [
        'model' => Dystore\Api\Domain\Prices\Models\Price::class,
        'model_contract' => Price::class,
        'policy' => PricePolicy::class,
        'schema' => PriceSchema::class,
        'resource' => PriceResource::class,
        'query' => PriceQuery::class,
        'collection_query' => PriceCollectionQuery::class,
        'routes' => null,
    ],

    SchemaType::get(ProductAssociation::class) => [
        'model' => Dystore\Api\Domain\ProductAssociations\Models\ProductAssociation::class,
        'model_contract' => ProductAssociation::class,
        'policy' => ProductAssociationPolicy::class,
        'schema' => ProductAssociationSchema::class,
        'resource' => ProductAssociationResource::class,
        'query' => ProductAssociationQuery::class,
        'collection_query' => ProductAssociationCollectionQuery::class,
        'routes' => null,
    ],

    SchemaType::get(ProductOption::class) => [
        'model' => Dystore\Api\Domain\ProductOptions\Models\ProductOption::class,
        'model_contract' => ProductOption::class,
        'policy' => ProductOptionPolicy::class,
        'schema' => ProductOptionSchema::class,
        'resource' => ProductOptionResource::class,
        'query' => ProductOptionQuery::class,
        'collection_query' => ProductOptionCollectionQuery::class,
        'routes' => null,
    ],

    SchemaType::get(ProductOptionValue::class) => [
        'model' => Dystore\Api\Domain\ProductOptionValues\Models\ProductOptionValue::class,
        'model_contract' => ProductOptionValue::class,
        'policy' => ProductOptionValuePolicy::class,
        'schema' => ProductOptionValueSchema::class,
        'resource' => ProductOptionValueResource::class,
        'query' => ProductOptionValueQuery::class,
        'collection_query' => ProductOptionValueCollectionQuery::class,
        'routes' => ProductOptionValueRouteGroup::class,
    ],

    SchemaType::get(ProductType::class) => [
        'model' => Dystore\Api\Domain\ProductTypes\Models\ProductType::class,
        'model_contract' => ProductType::class,
        'policy' => ProductTypePolicy::class,
        'schema' => ProductTypeSchema::class,
        'resource' => ProductTypeResource::class,
        'query' => ProductTypeQuery::class,
        'collection_query' => ProductTypeCollectionQuery::class,
        'routes' => null,
    ],

    SchemaType::get(Product::class) => [
        'model' => Dystore\Api\Domain\Products\Models\Product::class,
        'model_contract' => Product::class,
        'policy' => ProductPolicy::class,
        'schema' => ProductSchema::class,
        'resource' => ProductResource::class,
        'query' => ProductQuery::class,
        'collection_query' => ProductCollectionQuery::class,
        'routes' => ProductRouteGroup::class,
    ],

    SchemaType::get(ProductVariant::class) => [
        'model' => Dystore\Api\Domain\ProductVariants\Models\ProductVariant::class,
        'model_contract' => ProductVariant::class,
        'policy' => ProductVariantPolicy::class,
        'schema' => ProductVariantSchema::class,
        'resource' => ProductVariantResource::class,
        'query' => ProductVariantQuery::class,
        'collection_query' => ProductVariantCollectionQuery::class,
        'routes' => ProductVariantRouteGroup::class,
    ],

    SchemaType::get(ShippingOption::class) => [
        'model' => null,
        'model_contract' => null,
        'policy' => null,
        'schema' => ShippingOptionSchema::class,
        'resource' => ShippingOptionResource::class,
        'query' => ShippingOptionQuery::class,
        'collection_query' => ShippingOptionCollectionQuery::class,
        'routes' => ShippingOptionRouteGroup::class,
    ],

    SchemaType::get(Tag::class) => [
        'model' => Dystore\Api\Domain\Tags\Models\Tag::class,
        'model_contract' => Tag::class,
        'policy' => TagPolicy::class,
        'schema' => TagSchema::class,
        'resource' => TagResource::class,
        'query' => TagQuery::class,
        'collection_query' => TagCollectionQuery::class,
        'routes' => TagRouteGroup::class,
    ],

    SchemaType::get(Transaction::class) => [
        'model' => Dystore\Api\Domain\Transactions\Models\Transaction::class,
        'model_contract' => Transaction::class,
        'policy' => TransactionPolicy::class,
        'schema' => TransactionSchema::class,
        'resource' => TransactionResource::class,
        'query' => TransactionQuery::class,
        'collection_query' => TransactionCollectionQuery::class,
        'routes' => null,
    ],

    SchemaType::get(Url::class) => [
        'model' => Dystore\Api\Domain\Urls\Models\Url::class,
        'model_contract' => Url::class,
        'policy' => UrlPolicy::class,
        'schema' => UrlSchema::class,
        'resource' => UrlResource::class,
        'query' => UrlQuery::class,
        'collection_query' => UrlCollectionQuery::class,
        'routes' => UrlRouteGroup::class,
    ],

    SchemaType::get(User::class) => [
        'model' => Dystore\Api\Domain\Users\Models\User::class,
        'model_contract' => User::class,
        'policy' => UserPolicy::class,
        'schema' => UserSchema::class,
        'resource' => UserResource::class,
        'query' => UserQuery::class,
        'collection_query' => UserCollectionQuery::class,
        'routes' => UserRouteGroup::class,
    ],

    SchemaType::get(TaxZone::class) => [
        'model' => Dystore\Api\Domain\TaxZones\Models\TaxZone::class,
        'model_contract' => TaxZone::class,
        'policy' => TaxZonePolicy::class,
        'schema' => TaxZoneSchema::class,
        'resource' => TaxZoneResource::class,
        'query' => TaxZoneQuery::class,
        'collection_query' => TaxZoneCollectionQuery::class,
        'routes' => null,
    ],
];
