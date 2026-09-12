<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin\Concerns;

/**
 * @phpstan-consistent-constructor
 */
trait Makeable
{
    /**
     * Create a new instance of the class fluently.
     */
    public static function make(mixed ...$arguments): static
    {
        return new static(...$arguments);
    }
}
