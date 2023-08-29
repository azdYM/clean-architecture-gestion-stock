<?php

namespace App\Tests\Domain\Garantee;

use App\Domain\Garantee\Entity\Gold\Gold;

trait CreationItemTrait
{
    private function createGoldItem($name, $quantity, $carrat, $weight): Gold
    {
        return (new Gold)
            ->setName($name)
            ->setQuantity($quantity)
            ->setCarrat($carrat)
            ->setWeight($weight)
        ;
    }
}