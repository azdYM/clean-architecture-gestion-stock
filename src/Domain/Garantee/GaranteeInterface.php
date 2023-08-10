<?php

namespace App\Domain\Garantee;

use Doctrine\Common\Collections\Collection;

/**
 * L'interface GaranteeInterface représente un contrat pour les différentes garanties 
 * associées aux crédits dans le système.
*/
interface GaranteeInterface
{    
    public function calculateTotalValue(): self;
    public function getTotalValue(): int|float;
    
    /**
     * @return Collection<int, GaranteeItemInterface>
     */
    public function getItems(): Collection;
    public function addItem(GaranteeItemInterface $item): self;
}