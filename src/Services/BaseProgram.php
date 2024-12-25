<?php

namespace Mbsoft\Rewards\Services;

use Mbsoft\Rewards\Contracts\EarningInterface;
use Mbsoft\Rewards\Enums\ProgramType;
use Spatie\LaravelData\Data;

abstract class BaseProgram extends Data
{
    protected string $name;

    protected string $description;

    protected ProgramType $type;

    protected array $offers = [];

    public function __construct(array $config)
    {
        $this->name = $config['name'] ?? 'Generic Program';
        $this->description = $config['description'] ?? '';
        $this->type = $config['type'] ?? ProgramType::GENERIC;
    }

    abstract public function process(int $customer, array $context): mixed;

    // Getters
    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array|array<EarningInterface>
     */
    public function getOffers(): array
    {
        return $this->offers;
    }

    public function getOffer(string $hash): EarningInterface
    {
        return $this->offers[$hash];
    }

    public function addOffer(EarningInterface $offer): ?string
    {
        $offerHash = $offer->getHash();

        if (isset($this->offers[$offerHash])) {
            return null;
        }

        $this->offers[$offerHash] = $offer;

        return $offerHash;
    }

    public function removeOffer(string $hash): bool
    {
        if (isset($this->offers[$hash])) {
            unset($this->offers[$hash]);

            return true;
        }

        return false;
    }
}
