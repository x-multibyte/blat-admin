<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin\Schemas\Actions;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use XMultibyte\BlatAdmin\Concerns\Makeable;

/**
 * @implements Arrayable<string, mixed>
 *
 * @phpstan-consistent-constructor
 */
class Action implements Arrayable
{
    use Makeable;

    protected string $name;

    protected ?string $label = null;

    /**
     * @var (Closure(array<string, mixed>): string)|string|null
     */
    protected Closure|string|null $url = null;

    protected ?string $route = null;

    /**
     * @var array<string, mixed>
     */
    protected array $params = [];

    protected string $method = 'GET';

    protected ?string $icon = null;

    protected ?string $color = null;

    protected ?string $confirm = null;

    /**
     * @var array<string, mixed>
     */
    protected array $extra = [];

    public function __construct(string $name, ?string $label = null)
    {
        $this->name = $name;
        $this->label = $label ?? ucfirst(str_replace(['_', '-'], ' ', $name));
    }

    /**
     * @param  (Closure(array<string, mixed>): string)|string  $url
     */
    public function url(Closure|string $url): static
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public function route(string $route, array $params = []): static
    {
        $this->route = $route;
        $this->params = $params;

        return $this;
    }

    public function method(string $method): static
    {
        $this->method = strtoupper($method);

        return $this;
    }

    public function icon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function color(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function confirm(?string $message = null): static
    {
        $this->confirm = $message ?? 'Are you sure you want to perform this action?';

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

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * Resolve the action URL for a given row.
     *
     * @param  array<string, mixed>  $row
     */
    public function resolveUrl(array $row = []): ?string
    {
        if ($this->url instanceof Closure) {
            return ($this->url)($row);
        }

        if (is_string($this->url)) {
            $url = $this->url;
            foreach ($row as $key => $val) {
                if (is_scalar($val)) {
                    $url = str_replace('{'.$key.'}', (string) $val, $url);
                }
            }

            return $url;
        }

        if ($this->route !== null) {
            $resolvedParams = [];
            foreach ($this->params as $k => $v) {
                if (is_string($v) && str_starts_with($v, '{') && str_ends_with($v, '}')) {
                    $field = trim($v, '{}');
                    $resolvedParams[$k] = $row[$field] ?? $v;
                } else {
                    $resolvedParams[$k] = $v;
                }
            }

            return route($this->route, $resolvedParams);
        }

        return null;
    }

    /**
     * Convert the action into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge([
            'name' => $this->name,
            'label' => $this->label,
            'url' => is_string($this->url) ? $this->url : null,
            'route' => $this->route,
            'params' => $this->params,
            'method' => $this->method,
            'icon' => $this->icon,
            'color' => $this->color,
            'confirm' => $this->confirm,
        ], $this->extra);
    }
}
