<?php

use Dystore\Api\Domain\Tags\Models\Tag;
use Dystore\Api\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

it('can list all tags', function () {
    /** @var TestCase $this */
    $models = Tag::factory()
        ->count(3)
        ->create();

    $response = $this
        ->jsonApi()
        ->expects('tags')
        ->get('/api/v1/tags');

    $response
        ->assertFetchedMany($models)
        ->assertDoesntHaveIncluded();
})->group('tags');
