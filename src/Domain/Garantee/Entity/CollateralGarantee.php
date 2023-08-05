<?php

namespace App\Domain\Garantee\Entity;
use Doctrine\ORM\Mapping as ORM;

use App\Domain\Garantee\GaranteeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: CollateralGarantee::class)]
class CollateralGarantee implements GaranteeInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, CollateralGaranteeItem>
     */
    #[ORM\OneToMany(targetEntity: CollateralGaranteeItem::class, mappedBy: 'CollateralGarantee')]
    private Collection $items;

    private int|float $totalValue;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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