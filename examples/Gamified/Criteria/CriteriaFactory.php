<?php

namespace Mbsoft\Examples\Gamified\Criteria;

use InvalidArgumentException;
use Mbsoft\Rewards\Contracts\CriteriaInterface;

class CriteriaFactory
{
    public static function make(array $data): CriteriaInterface
    {
        $type = $data['type'];
        unset($data['type']);

        return match ($type) {
            'score_threshold'     => ScoreThresholdCriteria::fromArray($data),
            'event_participation' => EventParticipationCriteria::fromArray($data),
            'high_spender'        => HighSpenderCriteria::fromArray($data),
            'monthly_spender'     => MonthlySpenderCriteria::fromArray($data),
            'first_purchase'      => FirstPurchaseCriteria::fromArray($data),
            'purchase_frequency'  => PurchaseFrequencyCriteria::fromArray($data),
            default               => throw new InvalidArgumentException("Unknown criteria type: $type"),
        };
    }
}
