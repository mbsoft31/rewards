<?php

namespace Mbsoft\Examples\Gamified\Criteria;

use Mbsoft\Rewards\Contracts\CriteriaInterface;

readonly class ScoreThresholdCriteria implements CriteriaInterface
{
    public function __construct(
        private int $threshold
    ){}

    public function evaluate(int $id, array $context): bool
    {
        return $context['score'] >= $this->threshold;
    }

    public function toArray(): array
    {
        return [
            'type' => 'score_threshold',
            'criteria' => '$score >= $this->threshold',
            'threshold' => $this->threshold
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            threshold: $data['threshold']
        );
    }
}
