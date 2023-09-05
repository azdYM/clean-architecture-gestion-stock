<?php

namespace App\Domain\Garantee\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Garantee\Entity\Attestation;
use App\Domain\Garantee\AttestationInterface;
use App\Domain\Application\Entity\TimestampTrait;
use App\Domain\Application\Entity\IdentifiableTrait;

#[ORM\Entity()]
class AttestationApproval
{
    use IdentifiableTrait;
    use TimestampTrait;

    #[ORM\ManyToOne(targetEntity: Attestation::class, inversedBy: 'approvals')]
    #[ORM\JoinColumn(name: 'attestation_id', referencedColumnName: 'id')]
    private ?Attestation $attestation = null;

    #[ORM\ManyToOne(targetEntity: Employee::class)]
    #[ORM\JoinColumn(name: 'supervisor_id', referencedColumnName: 'id')]
    private ?Employee $approving = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

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

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    public function getApproving(): Employee
    {
        return $this->approving;
    }

    public function setApproving(Employee $approving): self
    {
        $this->approving = $approving;
        return $this;
    }
}