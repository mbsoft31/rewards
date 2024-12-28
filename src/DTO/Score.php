<?php

namespace Mbsoft\Rewards\DTO;

use Mbsoft\Rewards\Contracts\CalculatorInterface;
use Spatie\LaravelData\Data;

class Score extends Data
{
    /**
     * @param string $name
     * @param mixed $score
     * @param CalculatorInterface[] $calculators
     * @param array $metadata
     */
    public function __construct(
        public string $name,
        public mixed  $score = 0,
        public array  $calculators = [],
        public array  $metadata = [],
    ){}

    /**
     * Evaluate if all criteria for the badge are met.
     *
     * @param int $customer
     * @param array $context
     * @return mixed
     */
    public function calculate(int $customer, array $context): mixed
    {
        if (empty($this->calculators)) {
            return null;
        }
        $result = $context["calculators"] ?? [];
        foreach ($this->calculators as $key => $calculator) {
            if (!($calculator instanceof CalculatorInterface) ) {
                continue;
            }
            $calculated = array_pop($result);
            $result[] = $calculator->calculate($customer, [
                ...$context,
                "calculators" => $result,
                "result" => $calculated,
            ]);
        }
        $this->score = array_pop($result);
        return $this->score;
    }
}
