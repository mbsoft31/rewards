<?php

namespace Mbsoft\Rewards;

use Mbsoft\Rewards\Commands\RewardsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
