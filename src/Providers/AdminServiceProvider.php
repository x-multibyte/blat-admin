<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin\Providers;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Cookie\QueueingFactory;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use XMultibyte\BlatAdmin\Auth\AdminGuard;
use XMultibyte\BlatAdmin\Auth\AdminUserProvider;
use XMultibyte\BlatAdmin\Models\Admin;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerDefaultAuthConfig();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Auth::extend('blat-admin', function (Application $app, string $name, array $config): AdminGuard {
            /** @var string $providerName */
            $providerName = $config['provider'] ?? 'blat-admins';

            /** @var UserProvider $provider */
            $provider = Auth::createUserProvider($providerName);

            /** @var Session $session */
            $session = $app->make('session.store');

            /** @var Request|null $request */
            $request = $app->make('request');

            $guard = new AdminGuard(
                $name,
                $provider,
                $session,
                $request,
            );

            if ($app->bound('cookie')) {
                /** @var QueueingFactory $cookie */
                $cookie = $app->make('cookie');
                $guard->setCookieJar($cookie);
            }

            if ($app->bound('events')) {
                /** @var Dispatcher $events */
                $events = $app->make('events');
                $guard->setDispatcher($events);
            }

            return $guard;
        });

        Auth::provider('blat-admin', function (Application $app, array $config): AdminUserProvider {
            /** @var Hasher $hasher */
            $hasher = $app->make('hash');

            /** @var class-string<Model> $model */
            $model = $config['model'] ?? Admin::class;

            return new AdminUserProvider(
                $hasher,
                $model,
            );
        });
    }

    /**
     * Register default auth guard and provider configurations if not already set.
     */
    protected function registerDefaultAuthConfig(): void
    {
        /** @var Repository $config */
        $config = $this->app->make('config');

        if (! $config->has('auth.guards.blat-admin')) {
            $config->set('auth.guards.blat-admin', [
                'driver' => 'blat-admin',
                'provider' => 'blat-admins',
            ]);
        }

        if (! $config->has('auth.providers.blat-admins')) {
            $config->set('auth.providers.blat-admins', [
                'driver' => 'blat-admin',
                'model' => Admin::class,
            ]);
        }
    }
}
