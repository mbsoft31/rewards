<?php

namespace Mbsoft\Examples\Gamified\Achievements;

use Mbsoft\Examples\Gamified\Criteria\CriteriaFactory;
use Mbsoft\Rewards\DTO\Achievement;

class HighSpenderAchievement extends Achievement
{
    public function __construct(
        public string $name = "High Spender Achievement",
        public array $metadata = []
    ) {
        $this->criteria[] = CriteriaFactory::make([
            'type' => 'high_spender',
            ...$this->metadata,
        ]);
        parent::__construct($name, $this->criteria, $metadata);
    }
}
