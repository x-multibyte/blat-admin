<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin;

use Illuminate\Support\ServiceProvider;
use XMultibyte\BlatAdmin\Console\Commands\BlatAdminCommand;

class BlatAdminServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blat-admin.php', 'blat-admin');

        $this->app->singleton(BlatAdmin::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/blat-admin.php');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'blat-admin');

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'blat-admin');

        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../config/blat-admin.php' => config_path('blat-admin.php'),
        ], ['blat-admin', 'blat-admin-config']);

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/blat-admin'),
        ], ['blat-admin', 'blat-admin-views']);

        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath('vendor/blat-admin'),
        ], ['blat-admin', 'blat-admin-lang']);

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/blat-admin'),
        ], ['blat-admin', 'blat-admin-assets']);

        $this->publishesMigrations([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], ['blat-admin', 'blat-admin-migrations']);

        $this->commands([
            BlatAdminCommand::class,
        ]);
    }
}
