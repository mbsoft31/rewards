<?php

namespace Mbsoft\Examples\Gamified\Criteria;

use InvalidArgumentException;
use Mbsoft\Rewards\Contracts\CriteriaInterface;

readonly class MonthlySpenderCriteria implements CriteriaInterface
{
    public function __construct(
        private int $threshold,
    ) {}

    public function evaluate(int $id, array $context): bool
    {
        return $context['month_spent'] > $this->threshold;
    }

    public function toArray(): array
    {
        return [
            'type' => 'high_spender',
            'criteria' => '$month_spent > $this->threshold',
            'threshold' => $this->threshold,
        ];
    }

    public static function fromArray(array $data): CriteriaInterface
    {
        return new self(
            threshold: $data['threshold'] ?? throw new InvalidArgumentException('Threshold cannot be null.'),
        );
    }
}
