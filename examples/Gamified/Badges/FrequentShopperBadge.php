<?php

namespace Mbsoft\Examples\Gamified\Badges;

use Mbsoft\Examples\Gamified\Criteria\CriteriaFactory;
use Mbsoft\Rewards\DTO\Badge;

class FrequentShopperBadge extends Badge
{
    public function __construct(
        public string $name = "Frequent Shopper Badge",
        public array $metadata = []
    ) {
        $this->criteria[] = CriteriaFactory::make([
            'type' => 'purchase_frequency',
            'threshold' => 5, // 5 purchases to earn this badge
        ]);
        parent::__construct($name, $this->criteria, $metadata);
    }
}
