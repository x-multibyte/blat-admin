<?php

declare(strict_types=1);

use XMultibyte\BlatAdmin\BlatAdmin;

it('resolves the singleton', function () {
    expect(app(BlatAdmin::class))->toBeInstanceOf(BlatAdmin::class);
});

it('returns the same instance from the container', function () {
    expect(app(BlatAdmin::class))->toBe(app(BlatAdmin::class));
});

it('merges the package config', function () {
    expect(config('blat-admin.placeholder'))->toBe('default');
});

it('loads the package translations', function () {
    expect(trans('blat-admin::messages.placeholder'))->toBe('BlatAdmin placeholder translation.');
});

it('loads the package views', function () {
    expect(view()->exists('blat-admin::placeholder'))->toBeTrue();
});

it('registers the artisan command', function () {
    $this->artisan('blat-admin:placeholder')
        ->expectsOutputToContain('BlatAdmin placeholder command executed.')
        ->assertSuccessful();
});
