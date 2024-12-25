<?php

namespace Mbsoft\Rewards\Commands;

use Illuminate\Console\Command;

class RewardsCommand extends Command
{
    public $signature = 'rewards';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
