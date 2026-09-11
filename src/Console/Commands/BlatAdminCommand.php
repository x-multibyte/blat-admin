<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin\Console\Commands;

use Illuminate\Console\Command;

class BlatAdminCommand extends Command
{
    /**
     * The command signature.
     */
    protected $signature = 'blat-admin:placeholder';

    /**
     * The command description.
     */
    protected $description = 'Placeholder Artisan command shipped by the package blat-admin.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->line('BlatAdmin placeholder command executed.');

        return self::SUCCESS;
    }
}
