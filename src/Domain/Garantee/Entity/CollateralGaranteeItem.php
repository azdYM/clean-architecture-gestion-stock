<?php

namespace App\Domain\Garantee\Entity;

use App\Domain\Garantee\GaranteeItemInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;

#[MappedSuperclass(repositoryClass: CollateralGaranteeItem::class)]
abstract class CollateralGaranteeItem implements GaranteeItemInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    protected ?int $value = null;

    #[ORM\Column(type: 'text', nullable: true)]
    protected ?string $description;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    protected ?bool $validated = false;

    #[ORM\Column(type: 'datetime')]
    protected \DateTimeInterface $validatedAt;

    #[ORM\Column(type: 'datetime')]
    protected \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    protected \DateTimeInterface $updatedAt;

    #[ORM\ManyToOne(targetEntity: CollateralGarantee::class, inversedBy: 'CollateralGaranteeItem')]
    #[ORM\JoinColumn(name: 'collateral_garnatee_id')]
    protected ?CollateralGarantee $collateralGarantee = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCollateralGarantee(): ?CollateralGarantee
    {
        return $this->collateralGarantee;
    }

    public function setCollateralGarantee(CollateralGarantee $collateralGarantee): self
    {
        $this->collateralGarantee = $collateralGarantee;
        return $this;
    }

    public function getValue(): int|float
    {
        return $this->value;
    }

    public function setValue(int|float $value): self
    {
        $this->value = $value;
        return $this;
    }
}