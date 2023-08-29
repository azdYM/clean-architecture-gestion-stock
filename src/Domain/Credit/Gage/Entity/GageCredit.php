<?php

namespace App\Domain\Credit\Gage\Entity;

use App\Domain\Credit\Credit;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Employee\Employee;
use App\Domain\Contract\Entity\Contract;
use App\Domain\Mounting\Entity\GageFolder;
use App\Domain\Garantee\Entity\Attestation;
use App\Domain\Mounting\Entity\CreditAgent;
use Doctrine\Common\Collections\Collection;
use App\Domain\Application\CancellableInterface;
use App\Domain\Application\Entity\CancellableTrait;
use App\Domain\Credit\Gage\Repository\GageCreditRepository;

#[ORM\Entity(repositoryClass: GageCreditRepository::class)]
class GageCredit extends Credit implements CancellableInterface
{
    use CancellableTrait;

    #[ORM\Column]
    private ?int $capital = null;

    #[ORM\Column(nullable: true)]
    private ?int $idADBankingFolder = null;

    #[ORM\Column(nullable: true)]
    private ?string $code = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $startedAt = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $endAt = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\Column]
    private ?float $interest = null;

    #[ORM\OneToOne(targetEntity: GageFolder::class, mappedBy: 'credit')]
    private ?GageFolder $folder = null;

    #[ORM\OneToOne(targetEntity: Attestation::class)]
    #[ORM\JoinColumn(name: 'attestation_id', referencedColumnName: 'id')]
    private ?Attestation $attestation = null;

    #[ORM\ManyToOne(targetEntity: Employee::class)]
    #[ORM\JoinColumn(name: 'agent_id', referencedColumnName: 'id')]
    private ?CreditAgent $creditAgent = null;

    #[ORM\JoinTable(name: 'contracts_credits')]
    #[ORM\JoinColumn(name: 'credit_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'contract_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Contract::class)]
    private Collection $contracts;

    public function getAttestation(): Attestation
    {
        return $this->attestation;
    }

    public function setAttestation(Attestation $attestation): self
    {
        $this->attestation = $attestation;
        return $this;
    }

    public function getCapital(): int
    {
        return $this->capital;
    }

    public function setCapital(int $capital): self
    {
        $this->capital = $capital;
        return $this;
    }

    public function getIdADBankingFoder(): int
    {
        return $this->idADBankingFolder;
    }

    public function setIdADBankingFolder(int $idADBankingFolder): self
    {
        $this->idADBankingFolder = $idADBankingFolder;
        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getStartedAt(): \DateTimeInterface
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeInterface $startedAt): self
    {
        $this->startedAt = $startedAt;
        return $this;
    }

    public function getEndAt(): \DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    public function getInterest(): float
    {
        return $this->interest;
    }

    public function setInterest(float $interest): self
    {
        $this->interest = $interest;
        return $this;
    }

    public function getFolder(): GageFolder
    {
        return $this->folder;
    }

    public function setFolder(GageFolder $folder): self
    {
        $this->folder = $folder;
        return $this;
    }

    public function getCreditAgent(): CreditAgent
    {
        return $this->creditAgent;
    }

    public function setCreditAgent(CreditAgent $creditAgent): self
    {
        $this->creditAgent = $creditAgent;
        return $this;
    }

    public function getContracts(): Collection
    {
        return $this->contracts;
    }
}