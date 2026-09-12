<div align="center">
    <h1>Blat Admin</h1>
</div>

<p align="center">
    <a href="https://packagist.org/packages/x-multibyte/blat-admin"><img src="https://img.shields.io/packagist/v/x-multibyte/blat-admin.svg?style=flat-square" alt="Packagist"></a>
    <a href="https://packagist.org/packages/x-multibyte/blat-admin"><img src="https://img.shields.io/packagist/php-v/x-multibyte/blat-admin.svg?style=flat-square" alt="PHP from Packagist"></a>
    <a href="https://badge.laravel.cloud/badge/x-multibyte/blat-admin?style=flat" alt="Laravel versions"></a>
    <a href="https://github.com/x-multibyte/blat-admin/actions"><img alt="GitHub Workflow Status (main)" src="https://img.shields.io/github/actions/workflow/status/x-multibyte/blat-admin/tests.yml?branch=main&label=Tests&style=flat-square"></a>
    <a href="https://packagist.org/packages/x-multibyte/blat-admin"><img src="https://img.shields.io/packagist/dt/x-multibyte/blat-admin.svg?style=flat-square" alt="Total Downloads"></a>
</p>

`x-multibyte/blat-admin` is a JSON Schema-driven admin panel package for Laravel, powered by BlatUI. Build administrative interfaces with declarative schemas for forms, tables, and charts without generating boilerplate controllers, views, or routes.

## Features

- ⚡ **JSON Schema-Driven**: Define forms, data tables, and charts declaratively.
- 🎨 **BlatUI & Tailwind Ready**: Modern UI components with prebuilt zero-build assets or Vite theming support.
- 🔐 **Dedicated Authentication**: Isolated `Admin` model, session guard (`blat-admin`), and provider.
- 🔄 **Hybrid View Support**: Seamlessly fallback to custom Blade views when schema is not enough.

## Installation

Install the package via Composer:

```bash
composer require x-multibyte/blat-admin
```

Run the interactive install command:

```bash
php artisan blat-admin:install
```

This command will:
1. Publish configuration, assets, views, and migrations.
2. Run database migrations.
3. Prompt to create your initial Super Administrator account.

### Custom Vite Mode

If you prefer compiling assets with your own Vite and Tailwind CSS pipeline:

```bash
php artisan blat-admin:install --vite
```

## Quick Start

### 1. Register Schema Pages in Config

Define declarative pages in `config/blat-admin.php`:

```php
use XMultibyte\BlatAdmin\Schemas\TableSchema;
use XMultibyte\BlatAdmin\Schemas\Columns\TableColumn;
use XMultibyte\BlatAdmin\Schemas\Actions\Action;

return [
    'path' => 'admin',

    'pages' => [
        'users' => [
            'title' => 'User Management',
            'schema' => TableSchema::make('User Management')
                ->model(\App\Models\User::class)
                ->columns([
                    TableColumn::make('id', 'ID')->sortable(),
                    TableColumn::make('name', 'Name')->searchable(),
                    TableColumn::make('email', 'Email'),
                    TableColumn::make('role', 'Role')->badge(),
                ])
                ->actions([
                    Action::make('edit', 'Edit')->url('/admin/users/{id}/edit'),
                ])
                ->paginate(20)
                ->toArray(),
        ],
    ],
];
```

### 2. Register Pages Dynamically with BlatAdmin Facade

You can also register pages at runtime inside a Service Provider:

```php
use XMultibyte\BlatAdmin\Facades\BlatAdmin;
use XMultibyte\BlatAdmin\Schemas\FormSchema;
use XMultibyte\BlatAdmin\Schemas\Fields\FormField;

BlatAdmin::registerPage('settings', function () {
    return FormSchema::make('System Settings')
        ->action(route('admin.settings.store'))
        ->fields([
            FormField::make('site_name', 'Site Name')->required(),
            FormField::make('maintenance_mode', 'Maintenance Mode')->type('switch'),
        ]);
});
```

### 3. Chart Schemas

```php
use XMultibyte\BlatAdmin\Schemas\ChartSchema;

BlatAdmin::registerPage('analytics', function () {
    return ChartSchema::make('Monthly Revenue')
        ->type('area')
        ->series([
            ['name' => 'Revenue ($)', 'data' => [120, 200, 150, 300, 250, 400]],
        ])
        ->categories(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']);
});
```

## Testing

```bash
composer test
```

## Credits

- [Roy Thia](https://github.com/x-multibyte)
- [All Contributors](../../contributors)

## License

Blat Admin is open-sourced software licensed under the [MIT license](LICENSE.md).
