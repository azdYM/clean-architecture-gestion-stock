<?php

namespace App\Domain\Credit\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Domain\Application\DataFromADBankingInterface;
use App\Domain\Credit\Credit;
use App\Domain\Credit\Repository\ShortTermCreditRepository;
use App\Domain\Customer\ClientInterface;

#[ORM\MappedSuperclass(repositoryClass: ShortTermCreditRepository::class)]
abstract class ShortTermCredit extends Credit implements DataFromADBankingInterface
{
    #[ORM\Column]
    protected ?int $capital = null;

    #[ORM\Column(nullable: true)]
    protected ?int $idADBankingFolder = null;

    #[ORM\Column(nullable: true)]
    protected ?string $code = null;

    #[ORM\Column(type: 'datetime')]
    protected ?\DateTimeInterface $startedAt = null;

    #[ORM\Column(type: 'datetime')]
    protected ?\DateTimeInterface $endAt = null;

    #[ORM\Column(type: 'datetime')]
    protected ?\DateTimeInterface $createdAt = null;

    #[ORM\Column]
    protected ?int $duration = null;

    #[ORM\Column]
    protected ?float $interest = null;

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

    public function generateDataFromADBanking(): array
    {
        return [];
    }

    public function getClient(): ?ClientInterface
    {
        return $this->folder->getClient();
    }

    public function getGarantees(): Collection
    {
        return $this->folder->getGarantees();
    }
}