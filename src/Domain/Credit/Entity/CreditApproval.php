<?php

namespace App\Domain\Credit\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Credit\CreditInterface;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Application\Entity\TimestampTrait;
use App\Domain\Application\Entity\IdentifiableTrait;

#[ORM\Entity]
class CreditApproval
{
    use IdentifiableTrait;
    use TimestampTrait;

    #[ORM\OneToOne(targetEntity: Employee::class)]
    #[ORM\JoinColumn(name: 'approving_id', referencedColumnName: 'id')]
    private ?Employee $approving = null;

    #[ORM\ManyToOne(targetEntity: Credit::class, inversedBy: 'approvals')]
    #[ORM\JoinColumn(name: 'credit_id', referencedColumnName: 'id')]
    private ?Credit $credit = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

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

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }
}