<?php

declare(strict_types=1);

use XMultibyte\BlatAdmin\Models\Admin;

test('it runs install command in non-interactive mode with options', function (): void {
    $this->artisan('blat-admin:install', ['--force' => true, '--migrate' => true, '--no-interaction' => true])
        ->expectsOutputToContain('Installing Blat Admin...')
        ->expectsOutputToContain('Blat Admin installed successfully!')
        ->assertSuccessful();
});

test('it creates super admin interactively', function (): void {
    $this->artisan('blat-admin:install', ['--force' => true])
        ->expectsQuestion('Would you like to run the migrations now?', true)
        ->expectsQuestion('Would you like to create a Super Administrator account?', true)
        ->expectsQuestion('Administrator Name', 'Super Admin')
        ->expectsQuestion('Administrator Email', 'superadmin@example.com')
        ->expectsQuestion('Administrator Password', 'supersecret123')
        ->assertSuccessful();

    expect(Admin::where('email', 'superadmin@example.com')->exists())->toBeTrue();
});
