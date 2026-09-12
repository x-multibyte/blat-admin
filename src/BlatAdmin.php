<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin;

use Closure;
use Illuminate\Support\Facades\Config;
use XMultibyte\BlatAdmin\Contracts\SchemaContract;

class BlatAdmin
{
    /**
     * @var array<string, (Closure(): (SchemaContract|array<string, mixed>|string))|SchemaContract|array<string, mixed>|string>
     */
    protected array $pages = [];

    /**
     * @var list<array<string, mixed>>
     */
    protected array $navigation = [];

    /**
     * Register a dynamic schema or custom view page.
     *
     * @param  (Closure(): (SchemaContract|array<string, mixed>|string))|SchemaContract|array<string, mixed>|string  $schemaOrView
     */
    public function registerPage(string $key, Closure|SchemaContract|array|string $schemaOrView): static
    {
        $this->pages[$key] = $schemaOrView;

        return $this;
    }

    /**
     * Get a registered page by key, checking in-memory registry or config.
     *
     * @return (Closure(): (SchemaContract|array<string, mixed>|string))|SchemaContract|array<string, mixed>|string|null
     */
    public function getPage(string $key): Closure|SchemaContract|array|string|null
    {
        if (isset($this->pages[$key])) {
            return $this->pages[$key];
        }

        /** @var (Closure(): (SchemaContract|array<string, mixed>|string))|SchemaContract|array<string, mixed>|string|null $configPage */
        $configPage = Config::get('blat-admin.pages.'.$key);

        return $configPage;
    }

    /**
     * Get all registered pages.
     *
     * @return array<string, (Closure(): (SchemaContract|array<string, mixed>|string))|SchemaContract|array<string, mixed>|string>
     */
    public function getPages(): array
    {
        /** @var array<string, (Closure(): (SchemaContract|array<string, mixed>|string))|SchemaContract|array<string, mixed>|string> $configPages */
        $configPages = Config::get('blat-admin.pages', []);

        return array_merge($configPages, $this->pages);
    }

    /**
     * Set the navigation items.
     *
     * @param  list<array<string, mixed>>  $navigation
     */
    public function navigation(array $navigation): static
    {
        $this->navigation = $navigation;

        return $this;
    }

    /**
     * Add a navigation item.
     *
     * @param  array<string, mixed>  $item
     */
    public function addNavigationItem(array $item): static
    {
        $this->navigation[] = $item;

        return $this;
    }

    /**
     * Get all navigation items.
     *
     * @return list<array<string, mixed>>
     */
    public function getNavigation(): array
    {
        if (! empty($this->navigation)) {
            return $this->navigation;
        }

        /** @var list<array<string, mixed>> $configNav */
        $configNav = Config::get('blat-admin.navigation', []);

        return $configNav;
    }

    /**
     * Get the configured admin panel title.
     */
    public function title(): string
    {
        /** @var string $title */
        $title = Config::get('blat-admin.title', 'Blat Admin');

        return $title;
    }

    /**
     * Get the configured admin panel path prefix.
     */
    public function path(): string
    {
        /** @var string $path */
        $path = Config::get('blat-admin.path', 'admin');

        return $path;
    }
}
