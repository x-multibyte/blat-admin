<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use XMultibyte\BlatAdmin\Facades\BlatAdmin;

class Sidebar extends Component
{
    /**
     * @var list<array<string, mixed>>
     */
    public array $items;

    public string $title;

    /**
     * Create a new component instance.
     *
     * @param  list<array<string, mixed>>|null  $items
     */
    public function __construct(?array $items = null, ?string $title = null)
    {
        $this->items = $items ?? BlatAdmin::getNavigation();
        $this->title = $title ?? BlatAdmin::title();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        /** @var View $view */
        $view = view('blat-admin::components.sidebar');

        return $view;
    }
}
