<?php

namespace App\Domain\Garantee\Entity;

use App\Domain\Garantee\EvaluatedInterface;
use App\Domain\Garantee\EvaluationInterface;
use App\Domain\Garantee\Garantee;
use App\Domain\Garantee\GaranteeItemInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: CollateralGarantee::class)]
class CollateralGarantee extends Garantee implements EvaluatedInterface
{
    /**
     * @var Collection<int, CollateralGaranteeItem>
     */
    #[ORM\OneToMany(targetEntity: CollateralGaranteeItem::class, mappedBy: 'collateralGarantee')]
    private Collection $items;

    /**
     * @var Collection<int, EvaluationInterface>
     */
    #[ORM\OneToMany(targetEntity: Evaluation::class, mappedBy: 'garantee')]
    private Collection $evaluations;

    private int|float $totalValue;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->evaluations = new ArrayCollection();
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(GaranteeItemInterface $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
        }

        return $this;
    }

    public function getTotalValue(): int|float
    {
        return $this->totalValue;
    }

    public function calculateTotalValue(): self
    {
        foreach($this->items as $item) {
            $this->totalValue += $item->getValue();
        }

        return $this;
    }

    /**
     * @return Collection<int, EvaluationInterface>
     */
    public function getEvaluations(): Collection
    {
        return $this->evaluations;
    }

    public function addEvaluation(EvaluationInterface $evaluation): static
    {
        if (!$this->evaluations->contains($evaluation)) {
            $this->evaluations->add($evaluation);
        }

        return $this;
    }

    public function getLastEvaluation(): EvaluationInterface
    {
        return $this->evaluations->last();
    }
}