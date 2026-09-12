<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use XMultibyte\BlatAdmin\Facades\BlatAdmin;
use XMultibyte\BlatAdmin\Models\Admin;
use XMultibyte\BlatAdmin\Schemas\ChartSchema;
use XMultibyte\BlatAdmin\Schemas\Fields\FormField;
use XMultibyte\BlatAdmin\Schemas\FormSchema;
use XMultibyte\BlatAdmin\Schemas\TableSchema;

beforeEach(function (): void {
    $admin = Admin::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => 'secret123',
        'role' => 'admin',
        'is_active' => true,
    ]);

    Auth::guard('blat-admin')->login($admin);
});

test('it renders the dashboard page', function (): void {
    $response = $this->get(route('blat-admin.dashboard'));

    $response->assertStatus(200)
        ->assertSee('Total Administrators');
});

test('it renders registered FormSchema page', function (): void {
    BlatAdmin::registerPage('users/create', function () {
        return FormSchema::make('Create Administrator')
            ->fields([
                FormField::make('admin_name', 'Admin Name')->placeholder('Enter name'),
            ]);
    });

    $response = $this->get('/admin/users/create');

    $response->assertStatus(200)
        ->assertSee('Create Administrator')
        ->assertSee('Admin Name');
});

test('it renders registered TableSchema page', function (): void {
    BlatAdmin::registerPage('admins', function () {
        return TableSchema::make('Admin Directory')
            ->columns([
                ['key' => 'name', 'label' => 'Admin Name'],
            ])
            ->data([
                ['name' => 'Alice Administrator'],
            ]);
    });

    $response = $this->get('/admin/admins');

    $response->assertStatus(200)
        ->assertSee('Admin Directory')
        ->assertSee('Alice Administrator');
});

test('it renders registered ChartSchema page', function (): void {
    BlatAdmin::registerPage('reports/sales', function () {
        return ChartSchema::make('Yearly Metrics')
            ->type('bar');
    });

    $response = $this->get('/admin/reports/sales');

    $response->assertStatus(200)
        ->assertSee('Yearly Metrics');
});

test('it returns 404 for unmapped page', function (): void {
    $response = $this->get('/admin/non-existent-page-xyz');

    $response->assertStatus(404);
});
