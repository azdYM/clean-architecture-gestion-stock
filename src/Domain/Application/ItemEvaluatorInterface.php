<?php

namespace App\Domain\Application;

use App\Domain\Garantee\ItemInterface;


interface ItemEvaluatorInterface
{
    public function setItem(ItemInterface $item): self;
    public function generate(): int|float|\Throwable;
}