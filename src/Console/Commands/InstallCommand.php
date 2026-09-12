<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use XMultibyte\BlatAdmin\Models\Admin;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blat-admin:install
                            {--force : Overwrite existing published files}
                            {--migrate : Automatically run database migrations}
                            {--vite : Configure assets for Vite compilation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the BlatAdmin package, publish resources, and create the initial super administrator';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Installing Blat Admin...');

        $force = (bool) $this->option('force');

        // 1. Publish configuration
        $this->comment('Publishing configuration...');
        $this->callSilent('vendor:publish', [
            '--tag' => 'blat-admin-config',
            '--force' => $force,
        ]);

        // 2. Publish prebuilt assets
        if (! $this->option('vite')) {
            $this->comment('Publishing prebuilt assets...');
            $this->callSilent('vendor:publish', [
                '--tag' => 'blat-admin-assets',
                '--force' => $force,
            ]);
        }

        // 3. Publish views
        $this->comment('Publishing views...');
        $this->callSilent('vendor:publish', [
            '--tag' => 'blat-admin-views',
            '--force' => $force,
        ]);

        // 4. Publish migrations
        $this->comment('Publishing migrations...');
        $this->callSilent('vendor:publish', [
            '--tag' => 'blat-admin-migrations',
            '--force' => $force,
        ]);

        // 5. Run migrations
        if ($this->option('migrate') || ($this->input->isInteractive() && $this->confirm('Would you like to run the migrations now?', true))) {
            $this->comment('Running database migrations...');
            $this->call('migrate');
        }

        // 6. Create Super Administrator (if interactive or if no admins exist)
        if ($this->input->isInteractive()) {
            if ($this->confirm('Would you like to create a Super Administrator account?', true)) {
                $this->createSuperAdmin();
            }
        }

        $this->newLine();
        $this->info('Blat Admin installed successfully!');

        /** @var string $prefix */
        $prefix = Config::get('blat-admin.path', 'admin');
        $this->line(sprintf('Access your admin panel at: <comment>/%s</comment>', $prefix));

        return self::SUCCESS;
    }

    /**
     * Interactive prompt to create initial super admin.
     */
    protected function createSuperAdmin(): void
    {
        /** @var string $name */
        $name = $this->ask('Administrator Name', 'Admin');

        /** @var string $email */
        $email = $this->ask('Administrator Email', 'admin@example.com');

        /** @var string|null $password */
        $password = $this->secret('Administrator Password');

        while (empty($password)) {
            $this->error('Password cannot be empty.');
            /** @var string|null $password */
            $password = $this->secret('Administrator Password');
        }

        /** @var string $superRole */
        $superRole = Config::get('blat-admin.super_admin_role', 'super');

        /** @var class-string<Admin> $adminModel */
        $adminModel = Config::get('blat-admin.models.admin', Admin::class);

        $adminModel::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'role' => $superRole,
                'is_active' => true,
            ],
        );

        $this->info(sprintf('Super Administrator [%s] created successfully.', $email));
    }
}
