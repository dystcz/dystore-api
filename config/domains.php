<?php

use Dystore\Api\Support\Models\Actions\SchemaType;

/*
 * Lunar API domains configuration
 */
return [
    'auth' => [
        'schema' => Dystore\Api\Domain\Auth\JsonApi\V1\AuthSchema::class,
        'routes' => Dystore\Api\Domain\Auth\Http\Routing\AuthRouteGroup::class,
        'notifications' => [
            'reset_password' => Illuminate\Auth\Notifications\ResetPassword::class,
            'verify_email' => Illuminate\Auth\Notifications\VerifyEmail::class,
        ],
    ],

    SchemaType::get(Lunar\Models\Contracts\Address::class) => [
        'model' => Dystore\Api\Domain\Addresses\Models\Address::class,
        'model_contract' => Lunar\Models\Contracts\Address::class,
        'policy' => Dystore\Api\Domain\Addresses\Policies\AddressPolicy::class,
        'schema' => Dystore\Api\Domain\Addresses\JsonApi\V1\AddressSchema::class,
        'resource' => Dystore\Api\Domain\Addresses\JsonApi\V1\AddressResource::class,
        'query' => Dystore\Api\Domain\Addresses\JsonApi\V1\AddressQuery::class,
        'collection_query' => Dystore\Api\Domain\Addresses\JsonApi\V1\AddressCollectionQuery::class,
        'routes' => Dystore\Api\Domain\Addresses\Http\Routing\AddressRouteGroup::class,
    ],

    SchemaType::get(Lunar\Models\Contracts\Attribute::class) => [
        'model' => Dystore\Api\Domain\Attributes\Models\Attribute::class,
        'model_contract' => Lunar\Models\Contracts\Attribute::class,
        'policy' => Dystore\Api\Domain\Attributes\Policies\AttributePolicy::class,
        'schema' => Dystore\Api\Domain\Attributes\JsonApi\V1\AttributeSchema::class,
        'resource' => Dystore\Api\Domain\Attributes\JsonApi\V1\AttributeResource::class,
        'query' => Dystore\Api\Domain\Attributes\JsonApi\V1\AttributeQuery::class,
        'collection_query' => Dystore\Api\Domain\Attributes\JsonApi\V1\AttributeCollectionQuery::class,
        'routes' => null,
    ],

    SchemaType::get(Lunar\Models\Contracts\AttributeGroup::class) => [
        'model' => Dystore\Api\Domain\AttributeGroups\Models\AttributeGroup::class,
        'model_contract' => Lunar\Models\Contracts\AttributeGroup::class,
        'policy' => Dystore\Api\Domain\AttributeGroups\Policies\AttributeGroupPolicy::class,
        'schema' => Dystore\Api\Domain\AttributeGroups\JsonApi\V1\AttributeGroupSchema::class,
        'resource' => Dystore\Api\Domain\AttributeGroups\JsonApi\V1\AttributeGroupResource::class,
        'query' => Dystore\Api\Domain\AttributeGroups\JsonApi\V1\AttributeGroupQuery::class,
        'collection_query' => Dystore\Api\Domain\AttributeGroups\JsonApi\V1\AttributeGroupCollectionQuery::class,
        'routes' => null,
    ],

    SchemaType::get(Lunar\Models\Contracts\ProductAssociation::class) => [
        'model' => Dystore\Api\Domain\ProductAssociations\Models\ProductAssociation::class,
        'model_contract' => Lunar\Models\Contracts\ProductAssociation::class,
        'policy' => Dystore\Api\Domain\ProductAssociations\Policies\ProductAssociationPolicy::class,
        'schema' => Dystore\Api\Domain\ProductAssociations\JsonApi\V1\ProductAssociationSchema::class,
        'resource' => Dystore\Api\Domain\ProductAssociations\JsonApi\V1\ProductAssociationResource::class,
        'query' => Dystore\Api\Domain\ProductAssociations\JsonApi\V1\ProductAssociationQuery::class,
        'collection_query' => Dystore\Api\Domain\ProductAssociations\JsonApi\V1\ProductAssociationCollectionQuery::class,
        'routes' => null,
    ],

    SchemaType::get(Lunar\Models\Contracts\Brand::class) => [
        'model' => Dystore\Api\Domain\Brands\Models\Brand::class,
        'model_contract' => Lunar\Models\Contracts\Brand::class,
        'policy' => Dystore\Api\Domain\Brands\Policies\BrandPolicy::class,
        'schema' => Dystore\Api\Domain\Brands\JsonApi\V1\BrandSchema::class,
        'resource' => Dystore\Api\Domain\Brands\JsonApi\V1\BrandResource::class,
        'query' => Dystore\Api\Domain\Brands\JsonApi\V1\BrandQuery::class,
        'collection_query' => Dystore\Api\Domain\Brands\JsonApi\V1\BrandCollectionQuery::class,
        'routes' => Dystore\Api\Domain\Brands\Http\Routing\BrandRouteGroup::class,
    ],

    SchemaType::get(Lunar\Models\Contracts\CartAddress::class) => [
        'model' => Dystore\Api\Domain\CartAddresses\Models\CartAddress::class,
        'model_contract' => Lunar\Models\Contracts\CartAddress::class,
        'policy' => Dystore\Api\Domain\CartAddresses\Policies\CartAddressPolicy::class,
        'schema' => Dystore\Api\Domain\CartAddresses\JsonApi\V1\CartAddressSchema::class,
        'resource' => Dystore\Api\Domain\CartAddresses\JsonApi\V1\CartAddressResource::class,
        'query' => Dystore\Api\Domain\CartAddresses\JsonApi\V1\CartAddressQuery::class,
        'collection_query' => Dystore\Api\Domain\CartAddresses\JsonApi\V1\CartAddressCollectionQuery::class,
        'routes' => Dystore\Api\Domain\CartAddresses\Http\Routing\CartAddressRouteGroup::class,
    ],

    SchemaType::get(Lunar\Models\Contracts\CartLine::class) => [
        'model' => Dystore\Api\Domain\CartLines\Models\CartLine::class,
        'model_contract' => Lunar\Models\Contracts\CartLine::class,
        'policy' => Dystore\Api\Domain\CartLines\Policies\CartLinePolicy::class,
        'schema' => Dystore\Api\Domain\CartLines\JsonApi\V1\CartLineSchema::class,
        'resource' => Dystore\Api\Domain\CartLines\JsonApi\V1\CartLineResource::class,
        'query' => Dystore\Api\Domain\CartLines\JsonApi\V1\CartLineQuery::class,
        'collection_query' => Dystore\Api\Domain\CartLines\JsonApi\V1\CartLineCollectionQuery::class,
        'routes' => Dystore\Api\Domain\CartLines\Http\Routing\CartLineRouteGroup::class,
    ],

    SchemaType::get(Lunar\Models\Contracts\Cart::class) => [
        'model' => Dystore\Api\Domain\Carts\Models\Cart::class,
        'model_contract' => Lunar\Models\Contracts\Cart::class,
        'policy' => Dystore\Api\Domain\Carts\Policies\CartPolicy::class,
        'schema' => Dystore\Api\Domain\Carts\JsonApi\V1\CartSchema::class,
        'resource' => Dystore\Api\Domain\Carts\JsonApi\V1\CartResource::class,
        'query' => Dystore\Api\Domain\Carts\JsonApi\V1\CartQuery::class,
        'collection_query' => Dystore\Api\Domain\Carts\JsonApi\V1\CartCollectionQuery::class,
        'routes' => Dystore\Api\Domain\Carts\Http\Routing\CartRouteGroup::class,
    ],

    SchemaType::get(Lunar\Models\Contracts\Channel::class) => [
        'model' => Dystore\Api\Domain\Channels\Models\Channel::class,
        'model_contract' => Lunar\Models\Contracts\Channel::class,
        'policy' => Dystore\Api\Domain\Channels\Policies\ChannelPolicy::class,
        'schema' => Dystore\Api\Domain\Channels\JsonApi\V1\ChannelSchema::class,
        'resource' => Dystore\Api\Domain\Channels\JsonApi\V1\ChannelResource::class,
        'query' => Dystore\Api\Domain\Channels\JsonApi\V1\ChannelQuery::class,
        'collection_query' => Dystore\Api\Domain\Channels\JsonApi\V1\ChannelCollectionQuery::class,
        'routes' => Dystore\Api\Domain\Channels\Http\Routing\ChannelRouteGroup::class,
    ],

    SchemaType::get(Lunar\Models\Contracts\Collection::class) => [
        'model' => Dystore\Api\Domain\Collections\Models\Collection::class,
        'model_contract' => Lunar\Models\Contracts\Collection::class,
        'policy' => Dystore\Api\Domain\Collections\Policies\CollectionPolicy::class,
        'schema' => Dystore\Api\Domain\Collections\JsonApi\V1\CollectionSchema::class,
        'resource' => Dystore\Api\Domain\Collections\JsonApi\V1\CollectionResource::class,
        'query' => Dystore\Api\Domain\Collections\JsonApi\V1\CollectionQuery::class,
        'collection_query' => Dystore\Api\Domain\Collections\JsonApi\V1\CollectionCollectionQuery::class,
        'routes' => Dystore\Api\Domain\Collections\Http\Routing\CollectionRouteGroup::class,
    ],

    SchemaType::get(Lunar\Models\Contracts\CollectionGroup::class) => [
        'model' => Dystore\Api\Domain\CollectionGroups\Models\CollectionGroup::class,
        'model_contract' => Lunar\Models\Contracts\CollectionGroup::class,
        'policy' => Dystore\Api\Domain\CollectionGroups\Policies\CollectionGroupPolicy::class,
        'schema' => Dystore\Api\Domain\CollectionGroups\JsonApi\V1\CollectionGroupSchema::class,
        'resource' => Dystore\Api\Domain\CollectionGroups\JsonApi\V1\CollectionGroupResource::class,
        'query' => Dystore\Api\Domain\CollectionGroups\JsonApi\V1\CollectionGroupQuery::class,
        'collection_query' => Dystore\Api\Domain\CollectionGroups\JsonApi\V1\CollectionGroupCollectionQuery::class,
        'routes' => null,
    ],

    SchemaType::get(Lunar\Models\Contracts\Country::class) => [
        'model' => Dystore\Api\Domain\Countries\Models\Country::class,
        'model_contract' => Lunar\Models\Contracts\Country::class,
        'policy' => Dystore\Api\Domain\Countries\Policies\CountryPolicy::class,
        'schema' => Dystore\Api\Domain\Countries\JsonApi\V1\CountrySchema::class,
        'resource' => Dystore\Api\Domain\Countries\JsonApi\V1\CountryResource::class,
        'query' => Dystore\Api\Domain\Countries\JsonApi\V1\CountryQuery::class,
        'collection_query' => Dystore\Api\Domain\Countries\JsonApi\V1\CountryCollectionQuery::class,
        'routes' => Dystore\Api\Domain\Countries\Http\Routing\CountryRouteGroup::class,
    ],

    SchemaType::get(Lunar\Models\Contracts\Currency::class) => [
        'model' => Dystore\Api\Domain\Currencies\Models\Currency::class,
        'model_contract' => Lunar\Models\Contracts\Currency::class,
        'policy' => Dystore\Api\Domain\Currencies\Policies\CurrencyPolicy::class,
        'schema' => Dystore\Api\Domain\Currencies\JsonApi\V1\CurrencySchema::class,
        'resource' => Dystore\Api\Domain\Currencies\JsonApi\V1\CurrencyResource::class,
        'query' => Dystore\Api\Domain\Currencies\JsonApi\V1\CurrencyQuery::class,
        'collection_query' => Dystore\Api\Domain\Currencies\JsonApi\V1\CurrencyCollectionQuery::class,
        'routes' => Dystore\Api\Domain\Currencies\Http\Routing\CurrencyRouteGroup::class,
    ],

    SchemaType::get(Lunar\Models\Contracts\Customer::class) => [
        'model' => Dystore\Api\Domain\Customers\Models\Customer::class,
        'model_contract' => Lunar\Models\Contracts\Customer::class,
        'policy' => Dystore\Api\Domain\Customers\Policies\CustomerPolicy::class,
        'schema' => Dystore\Api\Domain\Customers\JsonApi\V1\CustomerSchema::class,
        'resource' => Dystore\Api\Domain\Customers\JsonApi\V1\CustomerResource::class,
        'query' => Dystore\Api\Domain\Customers\JsonApi\V1\CustomerQuery::class,
        'collection_query' => Dystore\Api\Domain\Customers\JsonApi\V1\CustomerCollectionQuery::class,
        'routes' => Dystore\Api\Domain\Customers\Http\Routing\CustomerRouteGroup::class,
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

    SchemaType::get(Spatie\MediaLibrary\MediaCollections\Models\Media::class) => [
        'model' => Spatie\MediaLibrary\MediaCollections\Models\Media::class,
        'model_contract' => null,
        'policy' => Dystore\Api\Domain\Media\Policies\MediaPolicy::class,
        'schema' => Dystore\Api\Domain\Media\JsonApi\V1\MediaSchema::class,
        'resource' => Dystore\Api\Domain\Media\JsonApi\V1\MediaResource::class,
        'query' => Dystore\Api\Domain\Media\JsonApi\V1\MediaQuery::class,
        'collection_query' => Dystore\Api\Domain\Media\JsonApi\V1\MediaCollectionQuery::class,
        'routes' => Dystore\Api\Domain\Media\Http\Routing\MediaRouteGroup::class,
    ],

    SchemaType::get(Lunar\Models\Contracts\Order::class) => [
        'model' => Dystore\Api\Domain\Orders\Models\Order::class,
        'model_contract' => Lunar\Models\Contracts\Order::class,
        'policy' => Dystore\Api\Domain\Orders\Policies\OrderPolicy::class,
        'schema' => Dystore\Api\Domain\Orders\JsonApi\V1\OrderSchema::class,
        'resource' => Dystore\Api\Domain\Orders\JsonApi\V1\OrderResource::class,
        'query' => Dystore\Api\Domain\Orders\JsonApi\V1\OrderQuery::class,
        'collection_query' => Dystore\Api\Domain\Orders\JsonApi\V1\OrderCollectionQuery::class,
        'routes' => Dystore\Api\Domain\Orders\Http\Routing\OrderRouteGroup::class,
    ],

    SchemaType::get(Lunar\Models\Contracts\OrderAddress::class) => [
        'model' => Dystore\Api\Domain\OrderAddresses\Models\OrderAddress::class,
        'model_contract' => Lunar\Models\Contracts\OrderAddress::class,
        'policy' => Dystore\Api\Domain\OrderAddresses\Policies\OrderAddressPolicy::class,
        'schema' => Dystore\Api\Domain\OrderAddresses\JsonApi\V1\OrderAddressSchema::class,
        'resource' => Dystore\Api\Domain\OrderAddresses\JsonApi\V1\OrderAddressResource::class,
        'query' => Dystore\Api\Domain\OrderAddresses\JsonApi\V1\OrderAddressQuery::class,
        'collection_query' => Dystore\Api\Domain\OrderAddresses\JsonApi\V1\OrderAddressCollectionQuery::class,
        'routes' => null,
    ],

    SchemaType::get(Lunar\Models\Contracts\OrderLine::class) => [
        'model' => Dystore\Api\Domain\OrderLines\Models\OrderLine::class,
        'model_contract' => Lunar\Models\Contracts\OrderLine::class,
        'policy' => Dystore\Api\Domain\OrderLines\Policies\OrderLinePolicy::class,
        'schema' => Dystore\Api\Domain\OrderLines\JsonApi\V1\OrderLineSchema::class,
        'resource' => Dystore\Api\Domain\OrderLines\JsonApi\V1\OrderLineResource::class,
        'query' => Dystore\Api\Domain\OrderLines\JsonApi\V1\OrderLineQuery::class,
        'collection_query' => Dystore\Api\Domain\OrderLines\JsonApi\V1\OrderLineCollectionQuery::class,
        'routes' => null,
    ],

    SchemaType::get(Dystore\Api\Domain\PaymentOptions\Entities\PaymentOption::class) => [
        'model' => null,
        'model_contract' => null,
        'policy' => null,
        'schema' => Dystore\Api\Domain\PaymentOptions\JsonApi\V1\PaymentOptionSchema::class,
        'resource' => Dystore\Api\Domain\PaymentOptions\JsonApi\V1\PaymentOptionResource::class,
        'query' => Dystore\Api\Domain\PaymentOptions\JsonApi\V1\PaymentOptionQuery::class,
        'collection_query' => Dystore\Api\Domain\PaymentOptions\JsonApi\V1\PaymentOptionCollectionQuery::class,
        'routes' => Dystore\Api\Domain\PaymentOptions\Http\Routing\PaymentOptionRouteGroup::class,
    ],

    SchemaType::get(Lunar\Models\Contracts\Price::class) => [
        'model' => Dystore\Api\Domain\Prices\Models\Price::class,
        'model_contract' => Lunar\Models\Contracts\Price::class,
        'policy' => Dystore\Api\Domain\Prices\Policies\PricePolicy::class,
        'schema' => Dystore\Api\Domain\Prices\JsonApi\V1\PriceSchema::class,
        'resource' => Dystore\Api\Domain\Prices\JsonApi\V1\PriceResource::class,
        'query' => Dystore\Api\Domain\Prices\JsonApi\V1\PriceQuery::class,
        'collection_query' => Dystore\Api\Domain\Prices\JsonApi\V1\PriceCollectionQuery::class,
        'routes' => null,
    ],

    SchemaType::get(Lunar\Models\Contracts\ProductAssociation::class) => [
        'model' => Dystore\Api\Domain\ProductAssociations\Models\ProductAssociation::class,
        'model_contract' => Lunar\Models\Contracts\ProductAssociation::class,
        'policy' => Dystore\Api\Domain\ProductAssociations\Policies\ProductAssociationPolicy::class,
        'schema' => Dystore\Api\Domain\ProductAssociations\JsonApi\V1\ProductAssociationSchema::class,
        'resource' => Dystore\Api\Domain\ProductAssociations\JsonApi\V1\ProductAssociationResource::class,
        'query' => Dystore\Api\Domain\ProductAssociations\JsonApi\V1\ProductAssociationQuery::class,
        'collection_query' => Dystore\Api\Domain\ProductAssociations\JsonApi\V1\ProductAssociationCollectionQuery::class,
        'routes' => null,
    ],

    SchemaType::get(Lunar\Models\Contracts\ProductOption::class) => [
        'model' => Dystore\Api\Domain\ProductOptions\Models\ProductOption::class,
        'model_contract' => Lunar\Models\Contracts\ProductOption::class,
        'policy' => Dystore\Api\Domain\ProductOptions\Policies\ProductOptionPolicy::class,
        'schema' => Dystore\Api\Domain\ProductOptions\JsonApi\V1\ProductOptionSchema::class,
        'resource' => Dystore\Api\Domain\ProductOptions\JsonApi\V1\ProductOptionResource::class,
        'query' => Dystore\Api\Domain\ProductOptions\JsonApi\V1\ProductOptionQuery::class,
        'collection_query' => Dystore\Api\Domain\ProductOptions\JsonApi\V1\ProductOptionCollectionQuery::class,
        'routes' => null,
    ],

    SchemaType::get(Lunar\Models\Contracts\ProductOptionValue::class) => [
        'model' => Dystore\Api\Domain\ProductOptionValues\Models\ProductOptionValue::class,
        'model_contract' => Lunar\Models\Contracts\ProductOptionValue::class,
        'policy' => Dystore\Api\Domain\ProductOptionValues\Policies\ProductOptionValuePolicy::class,
        'schema' => Dystore\Api\Domain\ProductOptionValues\JsonApi\V1\ProductOptionValueSchema::class,
        'resource' => Dystore\Api\Domain\ProductOptionValues\JsonApi\V1\ProductOptionValueResource::class,
        'query' => Dystore\Api\Domain\ProductOptionValues\JsonApi\V1\ProductOptionValueQuery::class,
        'collection_query' => Dystore\Api\Domain\ProductOptionValues\JsonApi\V1\ProductOptionValueCollectionQuery::class,
        'routes' => Dystore\Api\Domain\ProductOptionValues\Http\Routing\ProductOptionValueRouteGroup::class,
    ],

    SchemaType::get(Lunar\Models\Contracts\ProductType::class) => [
        'model' => Dystore\Api\Domain\ProductTypes\Models\ProductType::class,
        'model_contract' => Lunar\Models\Contracts\ProductType::class,
        'policy' => Dystore\Api\Domain\ProductTypes\Policies\ProductTypePolicy::class,
        'schema' => Dystore\Api\Domain\ProductTypes\JsonApi\V1\ProductTypeSchema::class,
        'resource' => Dystore\Api\Domain\ProductTypes\JsonApi\V1\ProductTypeResource::class,
        'query' => Dystore\Api\Domain\ProductTypes\JsonApi\V1\ProductTypeQuery::class,
        'collection_query' => Dystore\Api\Domain\ProductTypes\JsonApi\V1\ProductTypeCollectionQuery::class,
        'routes' => null,
    ],

    SchemaType::get(Lunar\Models\Contracts\Product::class) => [
        'model' => Dystore\Api\Domain\Products\Models\Product::class,
        'model_contract' => Lunar\Models\Contracts\Product::class,
        'policy' => Dystore\Api\Domain\Products\Policies\ProductPolicy::class,
        'schema' => Dystore\Api\Domain\Products\JsonApi\V1\ProductSchema::class,
        'resource' => Dystore\Api\Domain\Products\JsonApi\V1\ProductResource::class,
        'query' => Dystore\Api\Domain\Products\JsonApi\V1\ProductQuery::class,
        'collection_query' => Dystore\Api\Domain\Products\JsonApi\V1\ProductCollectionQuery::class,
        'routes' => Dystore\Api\Domain\Products\Http\Routing\ProductRouteGroup::class,
    ],

    SchemaType::get(Lunar\Models\Contracts\ProductVariant::class) => [
        'model' => Dystore\Api\Domain\ProductVariants\Models\ProductVariant::class,
        'model_contract' => Lunar\Models\Contracts\ProductVariant::class,
        'policy' => Dystore\Api\Domain\ProductVariants\Policies\ProductVariantPolicy::class,
        'schema' => Dystore\Api\Domain\ProductVariants\JsonApi\V1\ProductVariantSchema::class,
        'resource' => Dystore\Api\Domain\ProductVariants\JsonApi\V1\ProductVariantResource::class,
        'query' => Dystore\Api\Domain\ProductVariants\JsonApi\V1\ProductVariantQuery::class,
        'collection_query' => Dystore\Api\Domain\ProductVariants\JsonApi\V1\ProductVariantCollectionQuery::class,
        'routes' => Dystore\Api\Domain\ProductVariants\Http\Routing\ProductVariantRouteGroup::class,
    ],

    SchemaType::get(Dystore\Api\Domain\ShippingOptions\Entities\ShippingOption::class) => [
        'model' => null,
        'model_contract' => null,
        'policy' => null,
        'schema' => Dystore\Api\Domain\ShippingOptions\JsonApi\V1\ShippingOptionSchema::class,
        'resource' => Dystore\Api\Domain\ShippingOptions\JsonApi\V1\ShippingOptionResource::class,
        'query' => Dystore\Api\Domain\ShippingOptions\JsonApi\V1\ShippingOptionQuery::class,
        'collection_query' => Dystore\Api\Domain\ShippingOptions\JsonApi\V1\ShippingOptionCollectionQuery::class,
        'routes' => Dystore\Api\Domain\ShippingOptions\Http\Routing\ShippingOptionRouteGroup::class,
    ],

    SchemaType::get(Lunar\Models\Contracts\Tag::class) => [
        'model' => Dystore\Api\Domain\Tags\Models\Tag::class,
        'model_contract' => Lunar\Models\Contracts\Tag::class,
        'policy' => Dystore\Api\Domain\Tags\Policies\TagPolicy::class,
        'schema' => Dystore\Api\Domain\Tags\JsonApi\V1\TagSchema::class,
        'resource' => Dystore\Api\Domain\Tags\JsonApi\V1\TagResource::class,
        'query' => Dystore\Api\Domain\Tags\JsonApi\V1\TagQuery::class,
        'collection_query' => Dystore\Api\Domain\Tags\JsonApi\V1\TagCollectionQuery::class,
        'routes' => Dystore\Api\Domain\Tags\Http\Routing\TagRouteGroup::class,
    ],

    SchemaType::get(Lunar\Models\Contracts\Transaction::class) => [
        'model' => Dystore\Api\Domain\Transactions\Models\Transaction::class,
        'model_contract' => Lunar\Models\Contracts\Transaction::class,
        'policy' => Dystore\Api\Domain\Transactions\Policies\TransactionPolicy::class,
        'schema' => Dystore\Api\Domain\Transactions\JsonApi\V1\TransactionSchema::class,
        'resource' => Dystore\Api\Domain\Transactions\JsonApi\V1\TransactionResource::class,
        'query' => Dystore\Api\Domain\Transactions\JsonApi\V1\TransactionQuery::class,
        'collection_query' => Dystore\Api\Domain\Transactions\JsonApi\V1\TransactionCollectionQuery::class,
        'routes' => null,
    ],

    SchemaType::get(Lunar\Models\Contracts\Url::class) => [
        'model' => Dystore\Api\Domain\Urls\Models\Url::class,
        'model_contract' => Lunar\Models\Contracts\Url::class,
        'policy' => Dystore\Api\Domain\Urls\Policies\UrlPolicy::class,
        'schema' => Dystore\Api\Domain\Urls\JsonApi\V1\UrlSchema::class,
        'resource' => Dystore\Api\Domain\Urls\JsonApi\V1\UrlResource::class,
        'query' => Dystore\Api\Domain\Urls\JsonApi\V1\UrlQuery::class,
        'collection_query' => Dystore\Api\Domain\Urls\JsonApi\V1\UrlCollectionQuery::class,
        'routes' => Dystore\Api\Domain\Urls\Http\Routing\UrlRouteGroup::class,
    ],

    SchemaType::get(Dystore\Api\Domain\Users\Contracts\User::class) => [
        'model' => Dystore\Api\Domain\Users\Models\User::class,
        'model_contract' => Dystore\Api\Domain\Users\Contracts\User::class,
        'policy' => Dystore\Api\Domain\Users\Policies\UserPolicy::class,
        'schema' => Dystore\Api\Domain\Users\JsonApi\V1\UserSchema::class,
        'resource' => Dystore\Api\Domain\Users\JsonApi\V1\UserResource::class,
        'query' => Dystore\Api\Domain\Users\JsonApi\V1\UserQuery::class,
        'collection_query' => Dystore\Api\Domain\Users\JsonApi\V1\UserCollectionQuery::class,
        'routes' => Dystore\Api\Domain\Users\Http\Routing\UserRouteGroup::class,
    ],

    SchemaType::get(Lunar\Models\Contracts\TaxZone::class) => [
        'model' => Dystore\Api\Domain\TaxZones\Models\TaxZone::class,
        'model_contract' => Lunar\Models\Contracts\TaxZone::class,
        'policy' => Dystore\Api\Domain\TaxZones\Policies\TaxZonePolicy::class,
        'schema' => Dystore\Api\Domain\TaxZones\JsonApi\V1\TaxZoneSchema::class,
        'resource' => Dystore\Api\Domain\TaxZones\JsonApi\V1\TaxZoneResource::class,
        'query' => Dystore\Api\Domain\TaxZones\JsonApi\V1\TaxZoneQuery::class,
        'collection_query' => Dystore\Api\Domain\TaxZones\JsonApi\V1\TaxZoneCollectionQuery::class,
        'routes' => null,
    ],
];
