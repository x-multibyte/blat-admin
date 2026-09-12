<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\ServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use XMultibyte\BlatAdmin\BlatAdminServiceProvider;
use XMultibyte\BlatAdmin\Providers\AdminServiceProvider;

abstract class TestCase extends Orchestra
{
    use RefreshDatabase;

    /**
     * Get package providers.
     *
     * @param  Application  $app
     * @return list<class-string<ServiceProvider>>
     */
    protected function getPackageProviders($app): array
    {
        return [
            BlatAdminServiceProvider::class,
            AdminServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  Application  $app
     */
    protected function defineEnvironment($app): void
    {
        $app['config']->set('app.key', 'base64:6Cu/ozUs4DpLL0GbKNpas1Ez083CJfdLFt57FyWwAg8=');
        $app['config']->set('database.default', 'testing');
        $app['config']->set('session.driver', 'array');
    }
}
