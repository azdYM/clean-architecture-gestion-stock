<?php

namespace App\Domain\Credit;

use App\Domain\Credit\Entity\PawnCredit;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Garantee\Garantee;
use App\Domain\Customer\ClientInterface;
use App\Domain\Garantee\GaranteeInterface;
use App\Domain\Mounting\Entity\Folder;
use App\Domain\Mounting\FolderInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity()]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'credit_type', type: 'string')]
#[ORM\DiscriminatorMap([
    'credit' => Credit::class, 
    'pawn' => PawnCredit::class,
])]
abstract class Credit implements CreditInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\OneToMany(targetEntity: Garantee::class, mappedBy: 'credit')]
    protected Collection $garantees;

    #[ORM\OneToOne(targetEntity: Folder::class, mappedBy: 'credit')]
    protected ?FolderInterface $folder = null;
    
    public function __construct()
    {
        $this->garantees = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, GaranteeInterface>
     */
    public function getGarantees(): Collection
    {
        return $this->garantees;
    }

    public function addGarantee(GaranteeInterface $garantee): self
    {
        if (!$this->garantees->contains($garantee)) {
            $this->garantees->add($garantee);
        }

        return $this;
    }

    public function getFolder(): ?FolderInterface
    {
        return $this->folder;
    }

    public function setFolder(FolderInterface $credit): self
    {
        $this->folder = $credit;
        return $this;
    }

    abstract public function getClient(): ?ClientInterface;

}