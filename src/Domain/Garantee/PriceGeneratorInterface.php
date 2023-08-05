<?php

namespace App\Domain\Garantee;

interface PriceGeneratorInterfate
{
    public function setCarrat(int $carrat): self;
    public function generate(): int;
}