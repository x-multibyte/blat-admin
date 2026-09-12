<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use XMultibyte\BlatAdmin\Models\Admin;

test('unauthenticated guests are redirected to admin login', function (): void {
    $response = $this->get(route('blat-admin.dashboard'));

    $response->assertRedirect(route('blat-admin.login'));
});

test('unauthenticated api/json requests receive 401 unauthorized', function (): void {
    $response = $this->getJson(route('blat-admin.dashboard'));

    $response->assertStatus(401)
        ->assertJson(['message' => 'Unauthenticated.']);
});

test('authenticated active admins can access protected routes', function (): void {
    $admin = Admin::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => 'secret123',
        'role' => 'admin',
        'is_active' => true,
    ]);

    Auth::guard('blat-admin')->login($admin);

    $response = $this->get(route('blat-admin.dashboard'));

    $response->assertStatus(200)
        ->assertSee('Dashboard');
});
