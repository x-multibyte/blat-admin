<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin\Contracts;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @extends Arrayable<string, mixed>
 */
interface SchemaContract extends Arrayable
{
    /**
     * Get the title of the schema.
     */
    public function getTitle(): ?string;

    /**
     * Convert the schema instance to an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array;
}
