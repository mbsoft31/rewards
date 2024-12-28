<?php

namespace Mbsoft\Rewards\Contracts;

interface CriteriaInterface
{
    /**
     * Evaluate whether the criteria are met.
     *
     * @param  int  $id  user or customer id
     * @param  array  $context  attributes needed to evaluate the criteria
     * @return bool returns true if criteria is met and false otherwise
     */
    public function evaluate(int $id, array $context): bool;

    public function toArray(): array;

    public static function fromArray(array $data): self;
}
