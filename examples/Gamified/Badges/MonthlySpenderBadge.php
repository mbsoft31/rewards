<?php

namespace Mbsoft\Examples\Gamified\Badges;

use Mbsoft\Examples\Gamified\Criteria\CriteriaFactory;
use Mbsoft\Rewards\DTO\Badge;

class MonthlySpenderBadge extends Badge
{
    public function __construct(
        public string $name = 'Monthly Spender Badge',
        public array $metadata = []
    ) {
        $this->criteria[] = CriteriaFactory::make([
            'type' => 'monthly_spender',
            'threshold' => 1000, // Spend over 1000 in the month
        ]);
        parent::__construct($name, $this->criteria, $metadata);
    }
}
