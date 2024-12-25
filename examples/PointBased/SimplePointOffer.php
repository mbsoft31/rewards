<?php

namespace Mbsoft\Examples\PointBased;

use Mbsoft\Rewards\DTO\BaseOffer;

class SimplePointOffer extends BaseOffer
{
    public function calculateScore(mixed $id, array $context): int|float
    {
        if (!isset($context["amount"])) {
            return 0;
        }
        $amount = $context["amount"];
        $multiplier = $this->attributes["per_amount_spent"];
        return $amount * $multiplier;
    }

    public static function fromArray(array $data): SimplePointOffer
    {
        $offer = new static(
            attributes: $data["attributes"] ?? [],
            rewards: [],
            status: $data["status"] ?? []
        );
        foreach ($data["rewards"] as $rewardData) {
            $offer->rewards[$rewardData->getHash()] = $rewardData;
        }
        return $offer;
    }
}
