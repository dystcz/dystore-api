<?php

namespace Dystore\Api\Domain\Prices\JsonApi\V1;

use Dystore\Api\Domain\JsonApi\Eloquent\Schema;
use Dystore\Api\Domain\Prices\Actions\GetComparePriceDiscount;
use Dystore\Api\Domain\Prices\Actions\GetPrice;
use Dystore\Api\Domain\Prices\Actions\GetPriceWithoutDefaultTax;
use Dystore\Api\Domain\Prices\JsonApi\Filters\MaxPriceFilter;
use Dystore\Api\Domain\Prices\JsonApi\Filters\MinPriceFilter;
use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Fields\Map;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use Lunar\Models\Contracts\Price;

class PriceSchema extends Schema
{
    /**
     * {@inheritDoc}
     */
    public static string $model = Price::class;

    /**
     * {@inheritDoc}
     */
    public function fields(): array
    {
        return [
            $this->idField(),

            Map::make('base_price', [
                Str::make('formatted')
                    ->extractUsing(static function (Price $model) {
                        $price = (new GetPrice)($model->price, $model->priceable);

                        return $price->formatted();
                    }),
                Number::make('decimal')
                    ->extractUsing(static function (Price $model) {
                        $price = (new GetPrice)($model->price, $model->priceable);

                        return $price->decimal;
                    }),
                Number::make('value')
                    ->extractUsing(static function (Price $model) {
                        $price = (new GetPrice)($model->price, $model->priceable);

                        return $price->value;
                    }),
            ]),

            Map::make('sub_price', [
                Str::make('formatted')
                    ->extractUsing(static function (Price $model) {
                        $price = (new GetPriceWithoutDefaultTax)($model->price, $model->priceable);

                        return $price->formatted();
                    }),
                Number::make('decimal')
                    ->extractUsing(static function (Price $model) {
                        $price = (new GetPriceWithoutDefaultTax)($model->price, $model->priceable);

                        return $price->decimal;
                    }),
                Number::make('value')
                    ->extractUsing(static function (Price $model) {
                        $price = (new GetPriceWithoutDefaultTax)($model->price, $model->priceable);

                        return $price->value;
                    }),
            ]),

            Map::make('compare_price', [
                Str::make('formatted')
                    ->extractUsing(static function (Price $model) {
                        $comparePrice = (new GetPrice)($model->compare_price, $model->priceable);

                        return $comparePrice->formatted();
                    }),
                Number::make('decimal')
                    ->extractUsing(static function (Price $model) {
                        $comparePrice = (new GetPrice)($model->compare_price, $model->priceable);

                        return $comparePrice->decimal;
                    }),
                Number::make('value')
                    ->extractUsing(static function (Price $model) {
                        $comparePrice = (new GetPrice)($model->compare_price, $model->priceable);

                        return $comparePrice->value;
                    }),
            ]),

            Map::make('discount', [
                Number::make('formatted')
                    ->extractUsing(static function (Price $model) {
                        $price = (new GetPrice)($model->price, $model->priceable);
                        $comparePrice = (new GetPrice)($model->compare_price, $model->priceable);

                        return (new GetComparePriceDiscount($price, $comparePrice))->formatted();
                    }),
                Number::make('decimal')
                    ->extractUsing(static function (Price $model) {
                        $price = (new GetPrice)($model->price, $model->priceable);
                        $comparePrice = (new GetPrice)($model->compare_price, $model->priceable);

                        return (new GetComparePriceDiscount($price, $comparePrice))->decimal();
                    }),
                Number::make('value')
                    ->extractUsing(static function (Price $model) {
                        $price = (new GetPrice)($model->price, $model->priceable);
                        $comparePrice = (new GetPrice)($model->compare_price, $model->priceable);

                        return (new GetComparePriceDiscount($price, $comparePrice))->value();
                    }),
                Boolean::make('on_sale')
                    ->extractUsing(static function (Price $model) {
                        $price = (new GetPrice)($model->price, $model->priceable);
                        $comparePrice = (new GetPrice)($model->compare_price, $model->priceable);

                        return (new GetComparePriceDiscount($price, $comparePrice))->isOnSale();
                    }),
            ]),

            ...parent::fields(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function filters(): array
    {
        return [
            WhereIdIn::make($this),

            MinPriceFilter::make('min_price', 'price'),

            MaxPriceFilter::make('max_price', 'price'),

            ...parent::filters(),
        ];
    }
}
