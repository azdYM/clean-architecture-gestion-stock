<?php

namespace App\Domain\Garantee\Entity;

use App\Domain\Garantee\Garantee;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: CollateralGarantee::class)]
class CollateralGarantee extends Garantee
{
    /**
     * @var Collection<int, CollateralGaranteeItem>
     */
    #[ORM\OneToMany(targetEntity: CollateralGaranteeItem::class, mappedBy: 'collateralGarantee')]
    private Collection $items;

    private int|float $totalValue;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItems(CollateralGaranteeItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
        }

        return $this;
    }

    public function getValue(): int|float
    {
        return $this->totalValue;
    }

    public function calculateValue(): void
    {
        $this->totalValue = $this->calculateTotalValues();
    }

    private function calculateTotalValues(): int|float
    {
        $totalValue = 0;
        foreach($this->items as $item) {
            $totalValue += $item->getValue();
        }

        return $totalValue;
    }
}