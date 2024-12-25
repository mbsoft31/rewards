<?php

namespace Mbsoft\Rewards;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Mbsoft\Rewards\Commands\RewardsCommand;

class RewardsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('rewards')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_rewards_table')
            ->hasCommand(RewardsCommand::class);
    }
}
