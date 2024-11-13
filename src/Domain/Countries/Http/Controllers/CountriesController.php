<?php

namespace Dystore\Api\Domain\Countries\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\Countries\Contracts\CountriesController as CountriesControllerContract;
use Dystore\Api\Domain\Countries\JsonApi\V1\CountryCollectionQuery;
use Dystore\Api\Domain\Countries\JsonApi\V1\CountrySchema;
use Illuminate\Support\Facades\Cache;
use LaravelJsonApi\Core\Responses\DataResponse;

class CountriesController extends Controller implements CountriesControllerContract
{
    /**
     * Fetch zero to many JSON API resources.
     *
     * @param  PostSchema  $schema
     * @param  PostCollectionQuery  $request
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function index(CountrySchema $schema, CountryCollectionQuery $request): DataResponse
    {
        $models = Cache::rememberForever(
            'lunar-api.countries',
            fn () => $schema->repository()
                ->queryAll()
                ->withRequest($request)
                ->get(),
        );

        return DataResponse::make($models);
    }
}
