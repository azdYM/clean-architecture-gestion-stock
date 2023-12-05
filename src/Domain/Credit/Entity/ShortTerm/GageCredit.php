<?php

namespace App\Domain\Credit\Entity\ShortTerm;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Credit\Entity\Credit;
use App\Domain\Application\CancellableInterface;
use App\Domain\Application\Entity\CancellableTrait;
use App\Domain\Garantee\Entity\GaranteeAttestation;
use App\Domain\Mounting\Entity\ShortTerm\GageFolder;
use App\Domain\Credit\Repository\ShortTerm\GageCreditRepository;

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

    #[ORM\OneToOne(targetEntity: GaranteeAttestation::class)]
    #[ORM\JoinColumn(name: 'attestation_id', referencedColumnName: 'id')]
    private ?GaranteeAttestation $attestation = null;

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

    public function getAttestation(): GaranteeAttestation
    {
        return $this->attestation;
    }

    public function setAttestation(GaranteeAttestation $attestation): static
    {
        $this->attestation = $attestation;
        return $this;
    }
}