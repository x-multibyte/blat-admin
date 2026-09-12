<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    /**
     * @var list<array{title: string, url?: string}>
     */
    public array $items;

    /**
     * Create a new component instance.
     *
     * @param  list<array{title: string, url?: string}>  $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        /** @var View $view */
        $view = view('blat-admin::components.breadcrumb');

        return $view;
    }
}
