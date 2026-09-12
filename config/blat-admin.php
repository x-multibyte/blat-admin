<?php

declare(strict_types=1);

use XMultibyte\BlatAdmin\Models\Admin;

return [

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Route Prefix
    |--------------------------------------------------------------------------
    |
    | This value specifies the URI path prefix where your admin panel will be
    | accessible from. By default, it is set to 'admin'.
    |
    */

    'path' => 'admin',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Title
    |--------------------------------------------------------------------------
    |
    | The display title used across the admin layout header, title tag, and
    | sidebar branding.
    |
    */

    'title' => 'Blat Admin',

    /*
    |--------------------------------------------------------------------------
    | Authentication Guard & Providers
    |--------------------------------------------------------------------------
    |
    | The authentication guard and model used for managing administrator
    | sessions and authorization.
    |
    */

    'guard' => 'blat-admin',

    'super_admin_role' => 'super',

    'models' => [
        'admin' => Admin::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Middleware
    |--------------------------------------------------------------------------
    |
    | The middleware stack applied to all admin routes before the admin auth
    | middleware executes.
    |
    */

    'middleware' => [
        'web',
    ],

    /*
    |--------------------------------------------------------------------------
    | Assets Loading Mode
    |--------------------------------------------------------------------------
    |
    | Defines how static assets (CSS/JS) are loaded:
    | - 'prebuilt': Use package prebuilt CSS/JS assets (zero build step).
    | - 'vite': Use host application's Vite setup for customized theming.
    |
    */

    'assets' => [
        'mode' => 'prebuilt',
    ],

    /*
    |--------------------------------------------------------------------------
    | Predefined Schema Pages
    |--------------------------------------------------------------------------
    |
    | Declarative pages configured via Schema arrays or instances.
    |
    */

    'pages' => [],

    /*
    |--------------------------------------------------------------------------
    | Navigation Menu
    |--------------------------------------------------------------------------
    |
    | Custom navigation items rendered in the sidebar.
    |
    */

    'navigation' => [
        [
            'title' => 'Dashboard',
            'route' => 'blat-admin.dashboard',
            'icon' => 'home',
        ],
    ],

];
