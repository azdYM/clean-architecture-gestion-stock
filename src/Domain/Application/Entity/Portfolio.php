<?php

namespace App\Domain\Application\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

use App\Domain\Customer\Entity\Person;
use App\Domain\Customer\ClientInterface;
use App\Domain\Mounting\FolderInterface;
use Doctrine\Common\Collections\Collection;
use App\Domain\Application\PortfolioInterface;
use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\Application\Repository\PortfolioRepository;
use App\Domain\Mounting\Entity\GageFolder;

#[ORM\Entity(repositoryClass: PortfolioRepository::class)]
class Portfolio implements PortfolioInterface
{
    use IdentifiableTrait;
    use TimestampTrait;
    
    #[ORM\OneToOne(targetEntity: Person::class, inversedBy: 'portfolio')]
    #[ORM\JoinColumn(name: 'client_id', referencedColumnName: 'id', nullable: false)]
    private ?ClientInterface $client = null;

    /**
     * @var Collection<int, GageFolder>
     */
    #[ORM\OneToMany(targetEntity: GageFolder::class, mappedBy: 'portfolio')]
    private Collection $gageCreditFolders;

    public function __construct()
    {
        $this->gageCreditFolders = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
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

    public function getGageCreditFolders(): Collection
    {
        return $this->gageCreditFolders;
    }

    public function addGageCreditFolder(FolderInterface $folder): self
    {
        if (!$this->gageCreditFolders->contains($folder)) {
            $this->gageCreditFolders->add($folder);
        }

        return $this;
    }

    public function equals(Portfolio $other): bool
    {
        return $this->id === $other->getId();
    }

}