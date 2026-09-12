<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use XMultibyte\BlatAdmin\Schemas\FormSchema;

class Form extends Component
{
    /**
     * @var array<string, mixed>
     */
    public array $schema;

    /**
     * Create a new component instance.
     *
     * @param  FormSchema|array<string, mixed>  $schema
     */
    public function __construct(FormSchema|array $schema)
    {
        $this->schema = $schema instanceof FormSchema ? $schema->toArray() : $schema;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        /** @var View $view */
        $view = view('blat-admin::components.form');

        return $view;
    }
}
