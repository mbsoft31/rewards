<?php

namespace Mbsoft\Rewards\DTO;

use InvalidArgumentException;
use Mbsoft\Rewards\Contracts\CriteriaInterface;
use Spatie\LaravelData\Data;

class Level extends Data
{
    /**
     * @param  string  $name  Name of the level
     * @param  int  $threshold  Minimum score or condition required to unlock the level
     * @param  CriteriaInterface[]  $criteria  Additional criteria required for this level
     * @param  array  $metadata  Optional metadata for additional level details
     */
    public function __construct(
        public string $name,
        public int $threshold,
        public array $criteria = [],
        public array $metadata = []
    ) {}

    /**
     * Check if the customer meets the level requirements.
     */
    public function checkLevel(int $customer, array $context): bool
    {
        // Check if score meets the threshold
        if (! isset($context['score']) || $context['score'] < $this->threshold) {
            return false;
        }

        // Evaluate additional criteria
        foreach ($this->criteria as $criterion) {
            if (! $criterion->evaluate($customer, $context)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Create an instance from an array.
     *
     * @throws InvalidArgumentException
     */
    public static function fromArray(array $data): self
    {
        if (! isset($data['criteria']) || ! is_array($data['criteria'])) {
            throw new InvalidArgumentException('Criteria must be an array of CriteriaInterface instances.');
        }

        return new self(
            name: $data['name'],
            threshold: $data['threshold'],
            criteria: $data['criteria'],
            metadata: $data['metadata'] ?? []
        );
    }

    /**
     * Get the attributes of the class.
     */
    public static function getAttributes(): array
    {
        return [
            'name' => [
                'type' => 'string',
                'required' => true,
            ],
            'threshold' => [
                'type' => 'int',
                'required' => true,
            ],
            'criteria' => [
                'type' => 'array<CriteriaInterface>',
                'required' => false,
            ],
            'metadata' => [
                'type' => 'array',
                'required' => false,
            ],
        ];
    }
}
