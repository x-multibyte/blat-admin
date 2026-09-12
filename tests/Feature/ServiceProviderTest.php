<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

test('it merges package configuration', function (): void {
    expect(config('blat-admin.path'))->toBe('admin')
        ->and(config('blat-admin.guard'))->toBe('blat-admin')
        ->and(config('auth.guards.blat-admin.driver'))->toBe('blat-admin');
});

test('it registers admin routes', function (): void {
    expect(Route::has('blat-admin.login'))->toBeTrue()
        ->and(Route::has('blat-admin.dashboard'))->toBeTrue();
});

test('it registers views and component namespaces', function (): void {
    expect(View::exists('blat-admin::layouts.admin'))->toBeTrue()
        ->and(View::exists('blat-admin::pages.dashboard'))->toBeTrue()
        ->and(View::exists('blat-admin::pages.login'))->toBeTrue();
});
