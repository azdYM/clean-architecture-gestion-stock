<?php

namespace App\Domain\Application\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

use App\Domain\Customer\Entity\Person;
use App\Domain\Customer\ClientInterface;
use App\Domain\Mounting\FolderInterface;
use Doctrine\Common\Collections\Collection;
use App\Domain\Application\PortfolioInterface;
use App\Domain\Mounting\Entity\ShortTermFolder;
use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\Application\Repository\PortfolioRepository;

#[ORM\Entity(repositoryClass: PortfolioRepository::class)]
class Portfolio implements PortfolioInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\OneToOne(targetEntity: Person::class, inversedBy: 'portfolio')]
    #[ORM\JoinColumn(name: 'client_id', referencedColumnName: 'id')]
    private ?ClientInterface $client = null;

    /**
     * @var Collection<int, LongTermFolder>
     */
    private Collection $longTermCredits;

    /**
     * @var Collection<int, ShortTermFolder>
     */
    #[ORM\OneToMany(targetEntity: ShortTermFolder::class, mappedBy: 'portfolio')]
    private Collection $shortTermCredits;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->longTermCredits = new ArrayCollection();
        $this->shortTermCredits = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    public function setClient(ClientInterface $client): self
    {
        $this->client = $client;
        return $this;
    }

    public function getLongTermCredits(): Collection
    {
        return $this->longTermCredits;
    }

    public function addLongTermCredit(FolderInterface $longTermCredit): self
    {
        if (!$this->longTermCredits->contains($longTermCredit)) {
            $this->longTermCredits->add($longTermCredit);
        }

        return $this;
    }

    public function getShortTermCredits(): Collection
    {
        return $this->shortTermCredits;
    }

    public function addShortTermCredit(FolderInterface $shortTermCredit): self
    {
        if (!$this->shortTermCredits->contains($shortTermCredit)) {
            $this->shortTermCredits->add($shortTermCredit);
        }

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