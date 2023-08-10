<?php

namespace App\Domain\Application;

use App\Domain\Garantee\GaranteeItemInterface;

interface ItemEvaluatorInterface
{
    public function setItem(GaranteeItemInterface $item): self;
    public function generate(): int|float;
}