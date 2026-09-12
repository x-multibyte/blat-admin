<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin\Schemas\Columns;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use XMultibyte\BlatAdmin\Concerns\Makeable;

/**
 * @implements Arrayable<string, mixed>
 *
 * @phpstan-consistent-constructor
 */
class TableColumn implements Arrayable
{
    use Makeable;

    protected string $key;

    protected ?string $label = null;

    protected bool $sortable = false;

    protected bool $searchable = false;

    protected string $align = 'left';

    /**
     * @var bool|array<string, string>
     */
    protected bool|array $badge = false;

    /**
     * @var (Closure(mixed, array<string, mixed>): mixed)|string|null
     */
    protected Closure|string|null $format = null;

    /**
     * @var array<string, mixed>
     */
    protected array $extra = [];

    public function __construct(string $key, ?string $label = null)
    {
        $this->key = $key;
        $this->label = $label ?? ucfirst(str_replace(['_', '-'], ' ', $key));
    }

    public function sortable(bool $sortable = true): static
    {
        $this->sortable = $sortable;

        return $this;
    }

    public function searchable(bool $searchable = true): static
    {
        $this->searchable = $searchable;

        return $this;
    }

    public function align(string $align): static
    {
        $this->align = $align;

        return $this;
    }

    /**
     * @param  bool|array<string, string>  $badge
     */
    public function badge(bool|array $badge = true): static
    {
        $this->badge = $badge;

        return $this;
    }

    /**
     * @param  (Closure(mixed, array<string, mixed>): mixed)|string|null  $format
     */
    public function format(Closure|string|null $format): static
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @param  array<string, mixed>  $extra
     */
    public function extra(array $extra): static
    {
        $this->extra = array_merge($this->extra, $extra);

        return $this;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * Format a value according to column rules.
     *
     * @param  array<string, mixed>  $row
     */
    public function formatValue(mixed $value, array $row = []): mixed
    {
        if ($this->format instanceof Closure) {
            return ($this->format)($value, $row);
        }

        return $value;
    }

    /**
     * Convert the column into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge([
            'key' => $this->key,
            'label' => $this->label,
            'sortable' => $this->sortable,
            'searchable' => $this->searchable,
            'align' => $this->align,
            'badge' => $this->badge,
        ], $this->extra);
    }
}
