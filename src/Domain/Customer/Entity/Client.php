<?php

namespace App\Domain\Customer\Entity;

use App\Domain\Application\CreatorPortfolio;
use App\Domain\Application\Entity\Portfolio;
use App\Domain\Application\PortfolioCreatorInterface;
use App\Domain\Application\PortfolioInterface;
use App\Domain\Customer\ClientInterface;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass()]
abstract class Client extends Person implements ClientInterface, PortfolioCreatorInterface
{
    #[ORM\Column(type: 'integer', unique: true)]
    protected ?int $folio = null;

    #[ORM\Column(type: 'datetime', name: 'membership_at')]
    protected ?DateTimeInterface $membershipAt;

    #[ORM\OneToOne(targetEntity: Portfolio::class, mappedBy: 'individual', cascade: ['persist'])]
    protected ?PortfolioInterface $portfolio = null; 

    public function getFolio(): int
    {
        return $this->folio;
    }

    public function setFolio(int $folio): self
    {
        $this->folio = $folio;
        return $this;
    }

    public function getMembershipAt(): DateTimeInterface
    {
        return $this->membershipAt;
    }

    public function setMembershipAt(\DateTimeInterface $membershipAt): self
    {
        $this->membershipAt = $membershipAt;
        return $this;
    }
    public function getPortfolio(): PortfolioInterface
    {
        return $this->portfolio;
    }

    public function createPortfolio(): void
    {
        $this->portfolio = (new Portfolio)
            ->setClient($this)
        ;
    }
}