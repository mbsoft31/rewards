<?php

namespace Mbsoft\Rewards\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RewardsCommand extends Command
{
    // Define the command signature
    public $signature = 'rewards:install';

    // Command description
    public $description = 'Installs the necessary structure for the Rewards package.';

    public function handle(): int
    {
        $this->info('Installing Rewards package...');

        // Run the installation process
        $this->installDirectories();

        // Optionally, you can add other setup tasks such as publishing configuration files
        $this->publishConfig();
        $this->publishMigrations();

        $this->info('Rewards package installation completed.');

        return self::SUCCESS;
    }

    /**
     * Create the necessary directories in the `app` directory.
     */
    protected function installDirectories(): void
    {
        $dirs = [
            "Rewards",
            "Rewards/Achievements",
            "Rewards/Badges",
            "Rewards/Criteria",
            "Rewards/Programs",
        ];

        foreach ($dirs as $dir) {
            $path = app_path($dir);
            if (!is_dir($path)) {
                File::makeDirectory($path, 0755, true);
                $this->info("Created directory: $path");
            } else {
                $this->warn("Directory already exists: $path");
            }
        }
    }

    /**
     * Publish configuration files.
     */
    protected function publishConfig(): void
    {
        if ($this->confirm('Do you want to publish the configuration file?')) {
            $this->call('vendor:publish', [
                '--tag' => 'rewards-config',
            ]);
        }
    }

    /**
     * Publish migrations.
     */
    protected function publishMigrations(): void
    {
        if ($this->confirm('Do you want to publish the migration files?')) {
            $this->call('vendor:publish', [
                '--tag' => 'rewards-migrations',
            ]);
        }
    }
}
