<?php

namespace App\Domain\Mounting\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Credit\CreditInterface;
use App\Domain\Customer\ClientInterface;
use App\Domain\Mounting\FolderInterface;
use Doctrine\Common\Collections\Collection;
use App\Domain\Application\Entity\Portfolio;
use App\Domain\Application\PortfolioInterface;
use App\Domain\Credit\Credit;

#[ORM\MappedSuperclass()]
abstract class Folder implements FolderInterface
{
    #[ORM\Column(nullable: true)]
    protected ?string $state = null;

    #[ORM\OneToOne(targetEntity: Credit::class, inversedBy: 'folder')]
    #[ORM\JoinColumn(name: 'credit_id', referencedColumnName: 'id')]
    protected ?CreditInterface $credit = null;

    #[ORM\ManyToOne(targetEntity: Portfolio::class, inversedBy: 'folder')]
    #[ORM\JoinColumn(name: 'portfolio_id', referencedColumnName: 'id')]
    private ?PortfolioInterface $portfolio = null;

    #[ORM\Column(type: 'datetime')]
    protected \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    protected \DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getClient(): ?ClientInterface
    {
        return $this->portfolio->getClient();
    }

    /**
     * @return Collection<int, GaranteeInterface>
     */
    public function getGarantees(): Collection
    {
        return $this->credit->getGarantees();
    }

    public function getCredit(): ?CreditInterface
    {
        return $this->credit;
    }

    public function setCredit(CreditInterface $credit): self
    {
        $this->credit = $credit;
        return $this;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}