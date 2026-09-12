<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use XMultibyte\BlatAdmin\Models\Admin;

test('it displays the login page to guests', function (): void {
    $response = $this->get(route('blat-admin.login'));

    $response->assertStatus(200)
        ->assertSee('Admin Sign In');
});

test('it redirects authenticated admins away from login page', function (): void {
    $admin = Admin::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => 'secret123',
        'role' => 'admin',
        'is_active' => true,
    ]);

    Auth::guard('blat-admin')->login($admin);

    $response = $this->get(route('blat-admin.login'));

    $response->assertRedirect(route('blat-admin.dashboard'));
});

test('it allows active admins to authenticate', function (): void {
    Admin::create([
        'name' => 'Active Admin',
        'email' => 'admin@example.com',
        'password' => 'secret123',
        'role' => 'admin',
        'is_active' => true,
    ]);

    $response = $this->post(route('blat-admin.login.store'), [
        'email' => 'admin@example.com',
        'password' => 'secret123',
    ]);

    $response->assertRedirect(route('blat-admin.dashboard'));
    expect(Auth::guard('blat-admin')->check())->toBeTrue();
});

test('it denies authentication for inactive admins', function (): void {
    Admin::create([
        'name' => 'Inactive Admin',
        'email' => 'inactive@example.com',
        'password' => 'secret123',
        'role' => 'admin',
        'is_active' => false,
    ]);

    $response = $this->from(route('blat-admin.login'))->post(route('blat-admin.login.store'), [
        'email' => 'inactive@example.com',
        'password' => 'secret123',
    ]);

    $response->assertRedirect(route('blat-admin.login'))
        ->assertSessionHasErrors('email');

    expect(Auth::guard('blat-admin')->check())->toBeFalse();
});

test('it logs out authenticated admins', function (): void {
    $admin = Admin::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => 'secret123',
        'role' => 'admin',
        'is_active' => true,
    ]);

    Auth::guard('blat-admin')->login($admin);

    $response = $this->post(route('blat-admin.logout'));

    $response->assertRedirect(route('blat-admin.login'));
    expect(Auth::guard('blat-admin')->check())->toBeFalse();
});
