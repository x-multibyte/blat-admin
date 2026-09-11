<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use XMultibyte\BlatAdmin\BlatAdminServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            BlatAdminServiceProvider::class,
        ];
    }
}
