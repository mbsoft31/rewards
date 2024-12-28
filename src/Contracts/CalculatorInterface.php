<?php

namespace Mbsoft\Rewards\Contracts;

interface CalculatorInterface
{
    /**
     * Evaluate whether the criteria are met.
     *
     * @param  int  $id  user or customer id
     * @param  array  $context  attributes needed to evaluate the criteria
     * @return mixed returns true if criteria is met and false otherwise
     */
    public function calculate(int $id, array $context): mixed;

    public function toArray(): array;

    public static function fromArray(array $data): self;
}
