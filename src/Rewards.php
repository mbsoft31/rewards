<?php

namespace Mbsoft\Rewards;

use Mbsoft\Examples\Gamified\GamifiedProgram;
use Mbsoft\Rewards\Enums\ProgramType;

class Rewards
{
    protected array $programs = [];

    public function __construct(
        protected array $config = [],
    ) {}

    public function factory(array $config = []): Rewards
    {
        $this->config = $config;

        return $this;
    }

    public function create(
        ProgramType $type,
        string $name,
        string $description,
    ): Rewards {
        $this->programs[] = new GamifiedProgram([
            'type' => $type,
            'name' => $name,
            'description' => $description,
        ]);

        return $this->programs[count($this->programs) - 1];
    }

    public function addReward() {}
}
