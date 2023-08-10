<?php

namespace App\Domain\Credit\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Credit\Entity\PawnCredit;
use App\Domain\Credit\Repository\RenawalCreditRepository;
use App\Domain\Employee\Entity\CreditAgent;
use Doctrine\ORM\Mapping\JoinColumn;

#[ORM\Entity(repositoryClass: RenawalCreditRepository::class)]
class RenawalCredit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: PawnCredit::class)]
    #[ORM\JoinColumn(name: 'old_credit_id', referencedColumnName: 'id')]
    private ?PawnCredit $oldCredit;

    #[ORM\OneToOne(targetEntity: PawnCredit::class)]
    #[ORM\JoinColumn(name: 'new_credit_id', referencedColumnName: 'id')]
    private ?PawnCredit $newCredit;

    #[ORM\ManyToOne(targetEntity: CreditAgent::class)]
    #[JoinColumn(name: 'agent_id', referencedColumnName: 'id')]
    private ?CreditAgent $agent = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $renawaledAt = null;

    public function __construct()
    {
        $this->renawaledAt = new \DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOldCredit(): PawnCredit
    {
        return $this->oldCredit;
    }

    public function setOldCredit(PawnCredit $oldCredit): self
    {
        $this->oldCredit = $oldCredit;
        return $this;
    }

    public function getNewCredit(): PawnCredit
    {
        return $this->newCredit;
    }

    public function setNewCredit(PawnCredit $newCredit): self
    {
        $this->newCredit = $newCredit;
        return $this;
    }

    public function getRenawaledAt(): \DateTimeInterface
    {
        return $this->renawaledAt;
    }

    public function getAgent(): CreditAgent
    {
        return $this->agent;
    }

    public function setAgent(CreditAgent $agent): self
    {
        $this->agent = $agent;
        return $this;
    }
}