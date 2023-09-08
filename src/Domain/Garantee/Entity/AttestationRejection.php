<?php

namespace App\Domain\Garantee\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Garantee\Entity\Attestation;
use App\Domain\Garantee\AttestationInterface;
use App\Domain\Application\Entity\TimestampTrait;
use App\Domain\Application\Entity\IdentifiableTrait;

#[ORM\Entity()]
class AttestationRejection
{
    use IdentifiableTrait;
    use TimestampTrait;

    #[ORM\ManyToOne(targetEntity: Attestation::class, inversedBy: 'rejections')]
    #[ORM\JoinColumn(name: 'attestation_id', referencedColumnName: 'id')]
    private ?Attestation $attestation = null;

    #[ORM\ManyToOne(targetEntity: Employee::class)]
    #[ORM\JoinColumn(name: 'supervisor_id', referencedColumnName: 'id')]
    private ?Employee $supervisor = null;

    #[ORM\Column(length: 255)]
    private ?string $cause = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getAttestation(): ?AttestationInterface
    {
        return $this->attestation;
    }

    public function setAttestation(AttestationInterface $attestation): self
    {
        $this->attestation = $attestation;
        return $this;
    }

    public function getCause(): string
    {
        return $this->cause;
    }

    public function setCause(string $cause): self
    {
        $this->cause = $cause;
        return $this;
    }

    public function getSupervisor(): Employee
    {
        return $this->supervisor;
    }

    public function setSupervisor(Employee $supervisor): self
    {
        $this->supervisor = $supervisor;
        return $this;
    }
}