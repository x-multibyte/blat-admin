<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \XMultibyte\BlatAdmin\BlatAdmin
 */
class BlatAdmin extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \XMultibyte\BlatAdmin\BlatAdmin::class;
    }
}
