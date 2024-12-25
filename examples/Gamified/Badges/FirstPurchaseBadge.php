<?php

namespace Mbsoft\Examples\Gamified\Badges;

use Mbsoft\Examples\Gamified\Criteria\CriteriaFactory;
use Mbsoft\Rewards\DTO\Badge;

class FirstPurchaseBadge extends Badge
{
    public function __construct(
        public string $name = "First Purchase Badge",
        public array $metadata = []
    ) {
        $this->criteria[] = CriteriaFactory::make([
            'type' => 'first_purchase',
            ...$this->metadata,
        ]);
        parent::__construct($name, $this->criteria, $metadata);
    }
}
