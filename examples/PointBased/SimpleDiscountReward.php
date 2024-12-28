<?php

namespace Mbsoft\Examples\PointBased;

use Mbsoft\Rewards\DTO\BaseReward;

class SimpleDiscountReward extends BaseReward
{
    public function calculateReward(mixed $score, array $context = []): array
    {
        if (! isset($this->attributes['points_for_amount_discount'])) {
            return [];
        }
        $rate = $this->attributes['points_for_amount_discount'];

        return [
            'name' => 'discount',
            'type' => 'fixed',
            'amount' => $score / $rate,
        ];
    }

    public function canRedeem(mixed $score): bool
    {
        return $score >= $this->attributes['minimum_points_required'];
    }

    public function toArray(): array
    {
        return [
            'attributes' => $this->attributes,
            'canRedeem' => fn (int $score): bool => $this->canRedeem($score),
            'calculateReward' => fn (int $score, array $context = []): array => $this->calculateReward($score, $context),
        ];
    }
}
