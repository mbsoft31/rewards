<?php

namespace Mbsoft\Rewards;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Mbsoft\Rewards\Commands\RewardsCommand;

class RewardsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('rewards')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_rewards_table')
            ->hasCommand(RewardsCommand::class);
    }
}
