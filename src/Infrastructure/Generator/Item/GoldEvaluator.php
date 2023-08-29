<?php

namespace App\Infrastrucutre\Evaluator\Item;

use App\Domain\Garantee\ItemInterface;
use App\Domain\Garantee\Entity\Gold\Gold;
use App\Domain\Garantee\GaranteeItemInterface;
use App\Domain\Application\ItemEvaluatorInterface;
use App\Infrastrucutre\Generator\Price\GeneratePriceForItemException;

class GoldEvaluator implements ItemEvaluatorInterface
{
    private int $valuePerGramme;

    /**
     * @param Gold $item
     * @return self
     */
    public function setItem(ItemInterface $item): self
    {
        if (!$item instanceof Gold) {
            throw new GeneratePriceForItemException(
                sprintf('L\'evaluateur %s ne peut pas générer le prix de l\'item %s. Veuillez utiliser une instance de %s', GoldEvaluator::class, get_class($item), Gold::class)
            );
        }

        $carrat = $item->getCarrat();
        $this->valuePerGramme = match (true) {
            $carrat >= 21 => 15000,
            $carrat === 20 => 12500,
            $carrat >= 18 && $carrat <= 19 => 11500,
            $carrat >= 15 && $carrat <= 17 => 10000,
            $carrat >= 12 && $carrat <= 14 => 8500,
            $carrat >= 10 && $carrat <= 11 => 6500,
            default => throw new GeneratePriceForItemException(sprintf('le carrat %s n\'est pas pris en charge', $carrat))
        };

        return $this;
    }

    public function generate(): int|float
    {
        return $this->valuePerGramme;
    }
}