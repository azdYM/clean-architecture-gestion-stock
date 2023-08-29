<?php

namespace App\Domain\Garantee\Entity\Gold;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use App\Domain\Garantee\ItemInterface;
use App\Domain\Application\Entity\TimestampTrait;
use App\Domain\Application\Entity\IdentifiableTrait;
use App\Domain\Garantee\Entity\Gold\GoldAttestation;
use App\Domain\Garantee\Repository\Gold\GoldRepository;

#[Entity(repositoryClass: GoldRepository::class)]
class Gold implements ItemInterface
{
    use IdentifiableTrait;
    use TimestampTrait;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'integer', options: ['default' => 1])]
    private int $quantity = 1;

    #[ORM\Column(type: 'integer')]
    private int $carrat;

    #[ORM\Column(type: 'integer')]
    private int $unitPrice;

    #[ORM\Column(type: 'integer')]
    private int $weight;

    #[ORM\ManyToOne(targetEntity: GoldAttestation::class, inversedBy: 'items')]
    #[ORM\JoinColumn(name: 'attestation_id', referencedColumnName: 'id')]
    private ?GoldAttestation $attestation = null; 

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->$quantity = $quantity;
        return $this;
    }

    public function getCarrat(): int
    {
        return $this->carrat;
    }

    public function setCarrat(int $carrat): self
    {
        $this->carrat = $carrat;
        return $this;
    }

    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(int|float $unitPrice): self
    {
        $this->unitPrice = $unitPrice;
        return $this;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;
        return $this;
    }
}