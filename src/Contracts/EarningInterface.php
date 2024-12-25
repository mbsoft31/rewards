<?php
namespace Mbsoft\Rewards\Contracts;

interface EarningInterface
{
    public function calculateScore(mixed $id, array $context): mixed;

    public function getHash(): string;
}
