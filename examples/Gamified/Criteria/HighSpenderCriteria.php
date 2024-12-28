<?php

namespace Mbsoft\Examples\Gamified\Criteria;

use InvalidArgumentException;
use Mbsoft\Rewards\Contracts\CriteriaInterface;

readonly class HighSpenderCriteria implements CriteriaInterface
{
    public function __construct(
        private int $threshold,
    ) {}

    public function evaluate(int $id, array $context): bool
    {
        return $context['total_spent'] > $this->threshold;
    }

    public function toArray(): array
    {
        return [
            'type' => 'high_spender',
            'criteria' => '$total_spent > $this->threshold',
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
