<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use XMultibyte\BlatAdmin\Facades\BlatAdmin;

class Layout extends Component
{
    public ?string $title;

    /**
     * @var list<array{title: string, url?: string}>
     */
    public array $breadcrumbs;

    /**
     * Create a new component instance.
     *
     * @param  list<array{title: string, url?: string}>  $breadcrumbs
     */
    public function __construct(?string $title = null, array $breadcrumbs = [])
    {
        $this->title = $title ?? BlatAdmin::title();
        $this->breadcrumbs = $breadcrumbs;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        /** @var View $view */
        $view = view('blat-admin::components.layout');

        return $view;
    }
}
