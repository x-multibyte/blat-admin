<?php

declare(strict_types=1);

use XMultibyte\BlatAdmin\Schemas\ChartSchema;
use XMultibyte\BlatAdmin\Schemas\Fields\FormField;
use XMultibyte\BlatAdmin\Schemas\FormSchema;
use XMultibyte\BlatAdmin\Schemas\TableSchema;

test('it renders layout and sidebar components correctly', function (): void {
    $view = $this->blade('<x-blat-admin::layout title="Test Dashboard"><p>Welcome Admin</p></x-blat-admin::layout>');

    $view->assertSee('Test Dashboard')
        ->assertSee('Welcome Admin');
});

test('it renders form component correctly', function (): void {
    $schema = FormSchema::make('User Form')
        ->action('/admin/users')
        ->fields([
            FormField::make('username', 'User Name')->placeholder('Enter username'),
        ]);

    $view = $this->blade('<x-blat-admin::form :schema="$schema" />', ['schema' => $schema]);

    $view->assertSee('User Form')
        ->assertSee('User Name')
        ->assertSee('Enter username');
});

test('it renders table component correctly', function (): void {
    $schema = TableSchema::make('User Table')
        ->columns([
            ['key' => 'name', 'label' => 'Name'],
        ])
        ->data([
            ['name' => 'Alice'],
            ['name' => 'Bob'],
        ]);

    $view = $this->blade('<x-blat-admin::table :schema="$schema" />', ['schema' => $schema]);

    $view->assertSee('User Table')
        ->assertSee('Alice')
        ->assertSee('Bob');
});

test('it renders chart component correctly', function (): void {
    $schema = ChartSchema::make('Analytics Chart')
        ->type('bar');

    $view = $this->blade('<x-blat-admin::chart :schema="$schema" />', ['schema' => $schema]);

    $view->assertSee('Analytics Chart')
        ->assertSee('Bar Chart: Analytics Chart');
});

test('it renders login form component correctly', function (): void {
    $view = $this->blade('<x-blat-admin::login-form />');

    $view->assertSee('Admin Sign In')
        ->assertSee('Email Address')
        ->assertSee('Password');
});
