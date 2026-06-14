<?php

declare(strict_types=1);

namespace yasmuru\LaravelTinify\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use yasmuru\LaravelTinify\LaravelTinifyServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LaravelTinifyServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'Tinify' => \yasmuru\LaravelTinify\Facades\Tinify::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        // Setup default configuration
        $app['config']->set('tinify.apikey', 'test-api-key');
    }
}
