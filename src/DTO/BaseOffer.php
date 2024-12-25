<?php

namespace Mbsoft\Rewards\DTO;

use Mbsoft\Rewards\Contracts\EarningInterface;
use Mbsoft\Rewards\Contracts\RedeemingInterface;
use Mbsoft\Rewards\Enums\OfferStatus;
use Spatie\LaravelData\Data;

abstract class BaseOffer extends Data implements EarningInterface
{
    public function __construct(
        protected array $attributes = [],
        protected array $rewards = [],
        protected string|OfferStatus $status = 'active',
    ){}

    public function getStatus(): string|OfferStatus
    {
        return $this->status;
    }

    public function getRewards(): array
    {
        return $this->rewards;
    }

    public function addReward(RedeemingInterface $reward): ?string
    {
        $hash = $reward->getHash();
        if (isset($this->rewards[$hash])) {
            return null;
        }

        $this->rewards[$reward->getHash()] = $reward;

        return $hash;
    }

    public function removeReward(RedeemingInterface $reward): bool
    {
        if (isset($this->rewards[$reward->getHash()])) {
            unset($this->rewards[$reward->getHash()]);
            return true;
        }
        return false;
    }

    public function getHash(): string
    {
        return md5(serialize($this->attributes));
    }

    public function toArray(): array
    {
        return [
            "attributes" => $this->attributes,
            "rewards" => $this->rewards,
            "status" => $this->status,
        ];
    }

    public static function fromArray(array $data): BaseOffer
    {
        return new static(
            attributes: $data["attributes"] ?? [],
            rewards: $data["rewards"] ?? [],
            status: OfferStatus::tryFrom($data["status"]) ?? 'active',
        );
    }
}
