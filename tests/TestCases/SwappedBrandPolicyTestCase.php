<?php

namespace Dystore\Api\Tests\TestCases;

use Dystore\Api\Tests\TestCase;
use Illuminate\Support\Facades\Config;

abstract class SwappedBrandPolicyTestCase extends TestCase
{
    /**
     * @param  Application  $app
     */
    public function getEnvironmentSetUp($app): void
    {
        parent::getEnvironmentSetUp($app);

        Config::set(
            'lunar-api.domains.brands.policy',
            \Dystore\Api\Tests\Stubs\Policies\TestBrandPolicy::class,
        );
    }
}
