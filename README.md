<div align="center">
    <h1>Blat Admin</h1>
</div>

<p align="center">
    <a href="https://packagist.org/packages/x-multibyte/blat-admin"><img src="https://img.shields.io/packagist/v/x-multibyte/blat-admin.svg?style=flat-square" alt="Packagist"></a>
    <a href="https://packagist.org/packages/x-multibyte/blat-admin"><img src="https://img.shields.io/packagist/php-v/x-multibyte/blat-admin.svg?style=flat-square" alt="PHP from Packagist"></a>
    <a href="https://packagist.org/packages/x-multibyte/blat-admin"><img src="https://badge.laravel.cloud/badge/x-multibyte/blat-admin?style=flat" alt="Laravel versions"></a>
    <a href="https://github.com/x-multibyte/blat-admin/actions"><img alt="GitHub Workflow Status (main)" src="https://img.shields.io/github/actions/workflow/status/x-multibyte/blat-admin/tests.yml?branch=main&label=Tests&style=flat-square"></a>
    <a href="https://packagist.org/packages/x-multibyte/blat-admin"><img src="https://img.shields.io/packagist/dt/x-multibyte/blat-admin.svg?style=flat-square" alt="Total Downloads"></a>
</p>

Build an Admin Panel for Laravel projects with BlatUI.

## Installation

You can install the package via Composer:

```bash
composer require x-multibyte/blat-admin
```

You may publish all of the package's resources at once:

```bash
php artisan vendor:publish --tag="blat-admin"
```

Or, you may publish each resource individually:

### Publishing the Configuration File

```bash
php artisan vendor:publish --tag="blat-admin-config"
```

### Publishing and Running the Migrations

```bash
php artisan vendor:publish --tag="blat-admin-migrations"
php artisan migrate
```

### Publishing the Views

```bash
php artisan vendor:publish --tag="blat-admin-views"
```

### Publishing the Translations

```bash
php artisan vendor:publish --tag="blat-admin-lang"
```

### Publishing the Public Assets

```bash
php artisan vendor:publish --tag="blat-admin-assets"
```

## Usage

<!-- Add a basic usage example here. -->

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Thank you for considering contributing to Blat Admin! Please review our [contributing guide](.github/CONTRIBUTING.md) to get started.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Roy Thia](https://github.com/x-multibyte)
- [All Contributors](../../contributors)

## License

Blat Admin is open-sourced software licensed under the [MIT license](LICENSE.md).
