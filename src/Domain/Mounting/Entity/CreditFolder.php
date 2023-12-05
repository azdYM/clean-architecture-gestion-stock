<?php

namespace App\Domain\Mounting\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Mounting\FolderInterface;
use Doctrine\Common\Collections\Collection;
use App\Domain\Application\Entity\Portfolio;
use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\Application\Entity\TimestampTrait;
use App\Domain\Garantee\Entity\GaranteeAttestation;
use App\Domain\Application\Entity\IdentifiableTrait;
use App\Domain\Mounting\Entity\ShortTerm\GageFolder;

#[ORM\Entity]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap([
    'generic' => CreditFolder::class,
    'gage' => GageFolder::class,
    
    // Ajout d'une nouvelle attestation
])]
abstract class CreditFolder implements FolderInterface
{
    use IdentifiableTrait;
    use TimestampTrait;
    
    #[ORM\Column(nullable: true)]
    protected ?string $state = null;

    #[ORM\ManyToOne(targetEntity: MountingCreditFolderService::class)]
    #[ORM\JoinColumn(name: 'mounting_folder_service_id', referencedColumnName: 'id')]
    protected ?MountingCreditFolderService $mountingFolderService = null;

    #[ORM\ManyToOne(targetEntity: Portfolio::class, inversedBy: 'gageCreditFolders')]
    #[ORM\JoinColumn(name: 'portfolio_id', referencedColumnName: 'id')]
    protected ?Portfolio $portfolio = null;
    
    #[ORM\OneToMany(targetEntity: GaranteeAttestation::class, mappedBy: 'folder')]
    protected Collection $attestations;

    public function __construct()
    {
        $this->attestations = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
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

    public function getPortfolio(): ?Portfolio
    {
        return $this->portfolio;
    }

    public function setPortfolio(Portfolio $portfolio): self
    {
        $this->portfolio = $portfolio;
        return $this;
    }

    /**
     * @return Collection<int, GaranteeAttestation>
     */
    public function getAttestations(): Collection
    {
        return $this->attestations;
    }

    public function addAttestation(GaranteeAttestation $attestation): self
    {
        if (!$this->attestations->contains($attestation)) {
            $this->attestations->add($attestation);
        }

        return $this;
    }

    public function removeAttestation(GaranteeAttestation $attestation): self
    {
        if ($this->attestations->contains($attestation)) {
            $this->attestations->removeElement($attestation);
        }

        return $this;
    }

    public function getMountingFolderService(): ?MountingCreditFolderService
    {
        return $this->mountingFolderService;
    }

    public function setMountingFolderService(MountingCreditFolderService $mountingFolderService): self
    {
        $this->mountingFolderService = $mountingFolderService;
        return $this;
    }
}