<?php

namespace App\Domain\Garantee;

interface GaranteeItemInterface
{
    public function getValue(): int|float;
    public function setValue(int|float $value): self;
}