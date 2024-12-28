<?php

namespace Mbsoft\Rewards\Contracts;

interface RedeemingInterface
{
    public function calculateReward(mixed $score, array $context = []): mixed;

    public function canRedeem(mixed $score): bool;

    public function getHash(): string;
}
