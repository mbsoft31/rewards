<?php

namespace Mbsoft\Rewards\DTO;

use Mbsoft\Rewards\Contracts\RedeemingInterface;
use Spatie\LaravelData\Data;

abstract class BaseReward extends Data implements RedeemingInterface
{
    public array $attributes = [];
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function getHash(): string
    {
        return md5(serialize($this->attributes));
    }

    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
