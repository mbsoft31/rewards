<?php

namespace Mbsoft\Examples\Gamified\Criteria;

use Mbsoft\Rewards\Contracts\CriteriaInterface;

readonly class FirstPurchaseCriteria implements CriteriaInterface
{
    public function evaluate(int $id, array $context): bool
    {
        return $context['purchases'] > 0;
    }

    public function toArray(): array
    {
        return [
            'type' => 'first_purchase',
            'criteria' => '$purchases > 0',
        ];
    }

    public static function fromArray(array $data): CriteriaInterface
    {
        return new self;
    }
}
