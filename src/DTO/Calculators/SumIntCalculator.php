<?php

namespace Mbsoft\Rewards\DTO\Calculators;

use Mbsoft\Rewards\Contracts\CalculatorInterface;

class SumIntCalculator implements CalculatorInterface
{

    public function calculate(int $id, array $context): int
    {
        $sum = $context['result'] ?? 0;
        if ($value = array_pop($context['calculators'])) {
            if (!is_integer($value)) {
                throw new \InvalidArgumentException('Calculator value must be an integer.');
            }
            $sum += $value;
        }

        return $sum;
    }

    public function toArray(): array
    {
        return [
            'type' => 'sum',
            'calculator' => '$sum = ($result ?? 0) + pop($calculators)' ,
            ''
        ];
    }

    public static function fromArray(array $data): CalculatorInterface
    {
        // TODO: Implement fromArray() method.
    }
}
