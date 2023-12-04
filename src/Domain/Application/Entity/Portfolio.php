<?php

namespace App\Domain\Application\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

use App\Domain\Customer\Entity\Person;
use App\Domain\Customer\ClientInterface;
use App\Domain\Mounting\FolderInterface;
use Doctrine\Common\Collections\Collection;
use App\Domain\Mounting\Entity\CreditFolder;
use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\Application\Repository\PortfolioRepository;

#[ORM\Entity(repositoryClass: PortfolioRepository::class)]
class Portfolio
{
    use IdentifiableTrait;
    use TimestampTrait;
    
    #[ORM\OneToOne(targetEntity: Person::class)]
    #[ORM\JoinColumn(name: 'client_id', referencedColumnName: 'id', nullable: false)]
    private ?ClientInterface $client = null;

    /**
     * @var Collection<int, CreditFolder>
     */
    #[ORM\OneToMany(targetEntity: CreditFolder::class, mappedBy: 'portfolio')]
    private Collection $creditFolders;

    public function __construct()
    {
        $this->creditFolders = new ArrayCollection();
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

    public function getCreditFolders(): Collection
    {
        return $this->creditFolders;
    }

    public function addCreditFolder(FolderInterface $folder): self
    {
        if (!$this->creditFolders->contains($folder)) {
            $this->creditFolders->add($folder);
        }

        return $this;
    }

    public function equals(Portfolio $other): bool
    {
        return $this->id === $other->getId();
    }

}