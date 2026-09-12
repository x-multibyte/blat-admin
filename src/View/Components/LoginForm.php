<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LoginForm extends Component
{
    public string $action;

    public function __construct(?string $action = null)
    {
        $this->action = $action ?? route('blat-admin.login.store');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        /** @var View $view */
        $view = view('blat-admin::components.login-form');

        return $view;
    }
}
