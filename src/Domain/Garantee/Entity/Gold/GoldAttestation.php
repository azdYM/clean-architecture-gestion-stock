<?php

namespace App\Domain\Garantee\Entity\Gold;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Garantee\ItemInterface;
use App\Domain\Garantee\Entity\Gold\Gold;
use Doctrine\Common\Collections\Collection;
use App\Domain\Application\CancellableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\Application\Entity\CancellableTrait;
use App\Domain\Garantee\Entity\GaranteeAttestation;
use App\Domain\Garantee\Repository\Gold\GoldAttestationRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GoldAttestationRepository::class)]
class GoldAttestation extends GaranteeAttestation implements CancellableInterface
{
    
    use CancellableTrait;

    /** @var Collection<int, Gold> */
    #[ORM\OneToMany(targetEntity: Gold::class, mappedBy: 'attestation')]
    #[Groups(['Attestation'])]
    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * @return Collection<int, Gold>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(ItemInterface $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
        }

        return $this;
    }

    public function removeItem(Gold $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
        }

        return $this;
    }

    public function getValorisation(): int
    {
        return $this->calculateTotalValue();
    }

    private function calculateTotalValue(): int
    {
        $totalValue = 0;

        foreach($this->items as $item) {
            $totalValue += $item->getUnitPrice();
        }

        return $totalValue;
    }

    public static function create(): self
    {
        return new GoldAttestation();
    }
}