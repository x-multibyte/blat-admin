<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use XMultibyte\BlatAdmin\Auth\AdminGuard;
use XMultibyte\BlatAdmin\Models\Admin;

test('admin guard attempts login and checks active state', function (): void {
    $admin = Admin::create([
        'name' => 'Active Admin',
        'email' => 'active@example.com',
        'password' => 'password123',
        'role' => 'admin',
        'is_active' => true,
    ]);

    /** @var AdminGuard $guard */
    $guard = Auth::guard('blat-admin');

    expect($guard->attempt(['email' => 'active@example.com', 'password' => 'password123']))->toBeTrue()
        ->and($guard->check())->toBeTrue()
        ->and($guard->user()->id)->toBe($admin->id);
});

test('admin guard rejects inactive admin', function (): void {
    Admin::create([
        'name' => 'Inactive Admin',
        'email' => 'inactive@example.com',
        'password' => 'password123',
        'role' => 'admin',
        'is_active' => false,
    ]);

    /** @var AdminGuard $guard */
    $guard = Auth::guard('blat-admin');

    expect($guard->attempt(['email' => 'inactive@example.com', 'password' => 'password123']))->toBeFalse()
        ->and($guard->check())->toBeFalse()
        ->and($guard->user())->toBeNull();
});

test('admin guard logs out if active user becomes inactive', function (): void {
    $admin = Admin::create([
        'name' => 'User',
        'email' => 'user@example.com',
        'password' => 'password123',
        'role' => 'admin',
        'is_active' => true,
    ]);

    /** @var AdminGuard $guard */
    $guard = Auth::guard('blat-admin');
    $guard->login($admin);

    expect($guard->check())->toBeTrue();

    // Deactivate user in database and refresh in memory
    $admin->is_active = false;
    $admin->save();

    expect($guard->user())->toBeNull()
        ->and($guard->check())->toBeFalse();
});
