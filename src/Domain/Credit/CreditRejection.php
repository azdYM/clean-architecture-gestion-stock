<?php

namespace App\Domain\Credit;

use App\Domain\Credit\Credit;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Credit\CreditInterface;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Credit\Gage\Entity\GageCredit;
use App\Domain\Mounting\Entity\CreditSupervisor;
use App\Domain\Application\Entity\TimestampTrait;
use App\Domain\Application\Entity\IdentifiableTrait;

#[ORM\Entity]
class CreditRejection
{
    use IdentifiableTrait;
    use TimestampTrait;

    #[ORM\OneToOne(targetEntity: Employee::class)]
    #[ORM\JoinColumn(name: 'approving_id', referencedColumnName: 'id')]
    private ?Employee $approving = null;

    #[ORM\ManyToOne(targetEntity: GageCredit::class, inversedBy: 'rejections')]
    #[ORM\JoinColumn(name: 'credit_id', referencedColumnName: 'id')]
    private ?Credit $credit = null;

    #[ORM\Column(length: 255)]
    private ?string $cause = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
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

    public function getCredit(): CreditInterface
    {
        return $this->credit;
    }

    public function setCredit(CreditInterface $credit): self
    {
        $this->credit = $credit;
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
}