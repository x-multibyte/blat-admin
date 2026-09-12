<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use XMultibyte\BlatAdmin\Http\Controllers\AdminController;
use XMultibyte\BlatAdmin\Http\Controllers\AuthController;

/** @var string $prefix */
$prefix = Config::get('blat-admin.path', 'admin');

/** @var list<string> $middleware */
$middleware = Config::get('blat-admin.middleware', ['web']);

Route::middleware($middleware)
    ->prefix($prefix)
    ->name('blat-admin.')
    ->group(function (): void {
        // Guest authentication routes
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.store');

        // Protected administrator routes
        Route::middleware(['blat-admin.auth'])->group(function (): void {
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
            Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
            Route::get('/dashboard', [AdminController::class, 'dashboard']);
            Route::get('/{page}', [AdminController::class, 'show'])->where('page', '.*')->name('page');
        });
    });
