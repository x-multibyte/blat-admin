<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use XMultibyte\BlatAdmin\Models\Admin;

test('it can create an admin model with correct casts and attributes', function (): void {
    $admin = Admin::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'secret123',
        'role' => 'admin',
        'is_active' => true,
    ]);

    expect($admin->id)->toBeGreaterThan(0)
        ->and($admin->name)->toBe('John Doe')
        ->and($admin->email)->toBe('john@example.com')
        ->and(Hash::check('secret123', $admin->password))->toBeTrue()
        ->and($admin->is_active)->toBeTrue()
        ->and($admin->isActive())->toBeTrue()
        ->and($admin->isSuperAdmin())->toBeFalse();
});

test('it correctly identifies super administrators', function (): void {
    Config::set('blat-admin.super_admin_role', 'super');

    $superAdmin = Admin::create([
        'name' => 'Super User',
        'email' => 'super@example.com',
        'password' => 'secret123',
        'role' => 'super',
        'is_active' => true,
    ]);

    $regularAdmin = Admin::create([
        'name' => 'Regular User',
        'email' => 'regular@example.com',
        'password' => 'secret123',
        'role' => 'admin',
        'is_active' => true,
    ]);

    expect($superAdmin->isSuperAdmin())->toBeTrue()
        ->and($regularAdmin->isSuperAdmin())->toBeFalse();
});

test('it scopes active administrators', function (): void {
    Admin::create([
        'name' => 'Active 1',
        'email' => 'active1@example.com',
        'password' => 'secret',
        'role' => 'admin',
        'is_active' => true,
    ]);

    Admin::create([
        'name' => 'Inactive 1',
        'email' => 'inactive1@example.com',
        'password' => 'secret',
        'role' => 'admin',
        'is_active' => false,
    ]);

    expect(Admin::count())->toBe(2)
        ->and(Admin::active()->count())->toBe(1)
        ->and(Admin::active()->first()->email)->toBe('active1@example.com');
});
