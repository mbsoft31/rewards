<?php

namespace Mbsoft\Rewards\Contracts;

interface CalculatorInterface
{
    /**
     * Evaluate whether the criteria are met.
     *
     * @param int $id user or customer id
     * @param array $context attributes needed to evaluate the criteria
     * @return mixed returns true if criteria is met and false otherwise
     */
    public function calculate(int $id, array $context): mixed;

    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self;
}
