<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use XMultibyte\BlatAdmin\Auth\AdminUserProvider;
use XMultibyte\BlatAdmin\Models\Admin;

test('admin user provider retrieves only active admins by id', function (): void {
    $active = Admin::create([
        'name' => 'Active',
        'email' => 'active@example.com',
        'password' => 'secret',
        'role' => 'admin',
        'is_active' => true,
    ]);

    $inactive = Admin::create([
        'name' => 'Inactive',
        'email' => 'inactive@example.com',
        'password' => 'secret',
        'role' => 'admin',
        'is_active' => false,
    ]);

    /** @var AdminUserProvider $provider */
    $provider = Auth::createUserProvider('blat-admins');

    expect($provider->retrieveById($active->id))->not->toBeNull()
        ->and($provider->retrieveById($active->id)->getAuthIdentifier())->toBe($active->id)
        ->and($provider->retrieveById($inactive->id))->toBeNull();
});

test('admin user provider retrieves only active admins by credentials', function (): void {
    Admin::create([
        'name' => 'Active',
        'email' => 'active@example.com',
        'password' => 'secret',
        'role' => 'admin',
        'is_active' => true,
    ]);

    Admin::create([
        'name' => 'Inactive',
        'email' => 'inactive@example.com',
        'password' => 'secret',
        'role' => 'admin',
        'is_active' => false,
    ]);

    /** @var AdminUserProvider $provider */
    $provider = Auth::createUserProvider('blat-admins');

    expect($provider->retrieveByCredentials(['email' => 'active@example.com']))->not->toBeNull()
        ->and($provider->retrieveByCredentials(['email' => 'inactive@example.com']))->toBeNull();
});
