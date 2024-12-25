<?php

namespace Mbsoft\Examples\PointBased;

use Mbsoft\Rewards\Enums\OfferStatus;
use Mbsoft\Rewards\Enums\ProgramType;
use Mbsoft\Rewards\Services\BaseProgram;

class PointProgram extends BaseProgram
{
    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    public function process(int $customer, array $context): array
    {
        $out = [];

        foreach ($this->getOffers() as $offerHash => $offer) {
            $rewards = $offer->getRewards();
            if (empty($rewards)) {
                continue;
            }

            $score = $offer->calculateScore($customer, $context);

            foreach ($rewards as $rewardHash => $reward) {
                if (! $reward->canRedeem($score)) {
                    continue;
                }

                $value = $reward->calculateReward($score, $context);
                $out[] = [
                    'offer' => $offerHash,
                    'reward' => $rewardHash,
                    'value' => $value,
                ];
            }
        }

        return $out;
    }

    public static function example(array $transaction = ['amount' => 0]): void
    {
        $programData = [
            'id' => 1,
            'business_id' => 1,
            'name' => 'Points Based Program',
            'description' => 'Points Based Program',
            'type' => ProgramType::POINT_BASED,
        ];

        $simpleOffer = SimplePointOffer::fromArray([
            'attributes' => ['per_amount_spent' => 10],
            'rewards' => [],
            'status' => OfferStatus::Active,
        ]);

        $simpleDiscountReward = SimpleDiscountReward::fromArray([
            'points_for_amount_discount' => 100,
            'minimum_points_required' => 500,
        ]);

        $simpleOffer->addReward($simpleDiscountReward);

        $program = new PointProgram($programData);

        $program->addOffer($simpleOffer);

        $result = $program->process(123, $transaction);

        print_r($result);
    }
}
