<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin\Schemas;

use XMultibyte\BlatAdmin\Concerns\Makeable;
use XMultibyte\BlatAdmin\Contracts\SchemaContract;

/**
 * @phpstan-consistent-constructor
 */
class ChartSchema implements SchemaContract
{
    use Makeable;

    protected ?string $title = null;

    protected ?string $description = null;

    protected string $type = 'line';

    /**
     * @var list<array<string, mixed>>
     */
    protected array $series = [];

    /**
     * @var list<string>
     */
    protected array $categories = [];

    /**
     * @var list<string>
     */
    protected array $labels = [];

    protected int|string $height = 350;

    /**
     * @var list<string>
     */
    protected array $colors = [];

    /**
     * @var array<string, mixed>
     */
    protected array $options = [];

    public function __construct(?string $title = null)
    {
        $this->title = $title;
    }

    public function title(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function description(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function type(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param  list<array<string, mixed>>  $series
     */
    public function series(array $series): static
    {
        $this->series = $series;

        return $this;
    }

    /**
     * @param  list<string>  $categories
     */
    public function categories(array $categories): static
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @param  list<string>  $labels
     */
    public function labels(array $labels): static
    {
        $this->labels = $labels;

        return $this;
    }

    public function height(int|string $height): static
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @param  list<string>  $colors
     */
    public function colors(array $colors): static
    {
        $this->colors = $colors;

        return $this;
    }

    /**
     * @param  array<string, mixed>  $options
     */
    public function options(array $options): static
    {
        $this->options = $options;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getSeries(): array
    {
        return $this->series;
    }

    /**
     * @return list<string>
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @return list<string>
     */
    public function getLabels(): array
    {
        return $this->labels;
    }

    public function getHeight(): int|string
    {
        return $this->height;
    }

    /**
     * @return list<string>
     */
    public function getColors(): array
    {
        return $this->colors;
    }

    /**
     * @return array<string, mixed>
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Convert the schema into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'type' => 'chart',
            'chart_type' => $this->type,
            'title' => $this->title,
            'description' => $this->description,
            'series' => $this->series,
            'categories' => $this->categories,
            'labels' => $this->labels,
            'height' => $this->height,
            'colors' => $this->colors,
            'options' => $this->options,
        ];
    }
}
