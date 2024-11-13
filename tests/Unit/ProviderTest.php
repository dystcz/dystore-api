<?php

use Dystore\Api\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Lunar\Models\Brand;

uses(TestCase::class, RefreshDatabase::class);

it('extends Lunar models', function () {
    $lunarBrand = new Brand;

    // $lunarBrand will always be an instance of Lunar\Models\Brand
    expect($lunarBrand)
        ->not()->toBeInstanceOf(\Dystore\Api\Domain\Brands\Models\Brand::class)
        ->and($lunarBrand)->toBeInstanceOf(Brand::class);

    // when LunarApi Brand model gets registered in ModelManifest, then newInstance() method on Lunar Brand model returns instance of LunarApi Brand model
    expect($lunarBrand->newInstance())->toBeInstanceOf(\Dystore\Api\Domain\Brands\Models\Brand::class);
})->group('sp')->skip('Lunar model extending changed')->todo();
