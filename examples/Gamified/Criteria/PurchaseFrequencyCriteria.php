<?php

namespace Mbsoft\Examples\Gamified\Criteria;

use InvalidArgumentException;
use Mbsoft\Rewards\Contracts\CriteriaInterface;

readonly class PurchaseFrequencyCriteria implements CriteriaInterface
{

    public function __construct(
        private int $threshold,
    ){}

    public function evaluate(int $id, array $context): bool
    {
        return ($context['purchases'] >= $this->threshold);
    }

    public function toArray(): array
    {
        return [
            'type'        => 'purchase_frequency',
            'criteria'    => '$purchases >= $this->threshold',
            'threshold'   => $this->threshold,
        ];
    }

    public static function fromArray(array $data): CriteriaInterface
    {
        return new self(
            threshold: $data['threshold'] ?? throw new InvalidArgumentException('Threshold cannot be null.'),
        );
    }
}
