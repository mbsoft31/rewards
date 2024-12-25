<?php

namespace Mbsoft\Examples\Gamified\Criteria;

use Mbsoft\Rewards\Contracts\CriteriaInterface;

readonly class EventParticipationCriteria implements CriteriaInterface
{
    public function __construct(
        private int $event_id
    ){}

    public function evaluate(int $id, array $context): bool
    {
        return ($context['event'] ?? 0) == $this->event_id;
    }

    public function toArray(): array
    {
        return [
            'type' => 'event_participation',
            'criteria' => '$event >= $this->event_id',
            'event_id' => $this->event_id
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            event_id: $data['event_id']
        );
    }
}
