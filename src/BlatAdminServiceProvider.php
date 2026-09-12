<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use XMultibyte\BlatAdmin\Console\Commands\BlatAdminCommand;
use XMultibyte\BlatAdmin\Console\Commands\InstallCommand;
use XMultibyte\BlatAdmin\Http\Middleware\AdminAuthenticate;
use XMultibyte\BlatAdmin\Providers\AdminServiceProvider;

class BlatAdminServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blat-admin.php', 'blat-admin');

        $this->app->singleton(BlatAdmin::class);

        $this->app->register(AdminServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'blat-admin');

        Blade::componentNamespace('XMultibyte\\BlatAdmin\\View\\Components', 'blat-admin');

        $this->loadRoutesFrom(__DIR__.'/../routes/admin.php');

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'blat-admin');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        /** @var Router $router */
        $router = $this->app->make('router');
        $router->aliasMiddleware('blat-admin.auth', AdminAuthenticate::class);

        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->registerPublishes();

        $this->commands([
            BlatAdminCommand::class,
            InstallCommand::class,
        ]);
    }

    /**
     * Register the package's publishable resources.
     */
    protected function registerPublishes(): void
    {
        // 1. Config
        $this->publishes([
            __DIR__.'/../config/blat-admin.php' => config_path('blat-admin.php'),
        ], ['blat-admin', 'blat-admin-config']);

        // 2. Assets
        $this->publishes([
            __DIR__.'/../dist/blat-admin.css' => public_path('vendor/blat-admin/blat-admin.css'),
            __DIR__.'/../dist/blat-admin.js' => public_path('vendor/blat-admin/blat-admin.js'),
        ], ['blat-admin', 'blat-admin-assets']);

        // 3. Views
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/blat-admin'),
        ], ['blat-admin', 'blat-admin-views']);

        // 4. Translations
        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath('vendor/blat-admin'),
        ], ['blat-admin', 'blat-admin-lang']);

        // 5. Migrations
        $this->publishesMigrations([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], ['blat-admin', 'blat-admin-migrations']);

        // 6. Full bundle
        $this->publishes([
            __DIR__.'/../config/blat-admin.php' => config_path('blat-admin.php'),
            __DIR__.'/../dist/blat-admin.css' => public_path('vendor/blat-admin/blat-admin.css'),
            __DIR__.'/../dist/blat-admin.js' => public_path('vendor/blat-admin/blat-admin.js'),
            __DIR__.'/../resources/views' => resource_path('views/vendor/blat-admin'),
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'blat-admin-full');
    }
}
