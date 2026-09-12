<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin\View\Components;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\View\Component;

class Header extends Component
{
    public ?Authenticatable $user;

    public function __construct()
    {
        /** @var string $guard */
        $guard = Config::get('blat-admin.guard', 'blat-admin');
        $this->user = Auth::guard($guard)->user();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        /** @var View $view */
        $view = view('blat-admin::components.header');

        return $view;
    }
}
