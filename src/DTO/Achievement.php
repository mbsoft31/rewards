<?php
namespace Mbsoft\Rewards\DTO;

use InvalidArgumentException;
use Spatie\LaravelData\Data;
use Mbsoft\Rewards\Contracts\CriteriaInterface;

class Achievement extends Data
{
    /**
     * @param string $name Name of the achievement
     * @param CriteriaInterface[] $criteria List of criteria objects
     * @param array $metadata Optional metadata for additional achievement details
     */
    public function __construct(
        public string $name,
        public array $criteria,
        public array $metadata = []
    ) {}

    /**
     * Evaluate if all criteria for the achievement are met.
     *
     * @param int $customer
     * @param array $context
     * @return bool
     */
    public function evaluate(int $customer, array $context): bool
    {
        foreach ($this->criteria as $criterion) {
            if (!$criterion->evaluate($customer, $context)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Create an instance from an array.
     *
     * @param array $data
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fromArray(array $data): self
    {
        if (!isset($data['criteria']) || !is_array($data['criteria'])) {
            throw new InvalidArgumentException('Criteria must be an array of CriteriaInterface instances.');
        }

        return new self(
            name: $data['name'],
            criteria: $data['criteria'],
            metadata: $data['metadata'] ?? []
        );
    }

    /**
     * Get the attributes of the class.
     *
     * @return array
     */
    public static function getAttributes(): array
    {
        return [
            'name' => [
                'type' => 'string',
                'required' => true,
            ],
            'criteria' => [
                'type' => 'array<CriteriaInterface>',
                'required' => true,
            ],
            'metadata' => [
                'type' => 'array',
                'required' => false,
            ],
        ];
    }
}
