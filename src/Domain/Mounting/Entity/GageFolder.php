<?php

namespace App\Domain\Mounting\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Credit\CreditInterface;
use App\Domain\Mounting\FolderInterface;
use App\Domain\Garantee\Entity\Attestation;
use Doctrine\Common\Collections\Collection;
use App\Domain\Application\Entity\Portfolio;
use App\Domain\Credit\Gage\Entity\GageCredit;
use App\Domain\Garantee\AttestationInterface;
use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\Application\Entity\TimestampTrait;
use App\Domain\Application\Entity\IdentifiableTrait;
use App\Domain\Credit\Gage\Entity\RenawalGageCredit;
use App\Domain\Mounting\Repository\GageFolderRepository;

#[ORM\Entity(repositoryClass: GageFolderRepository::class)]
class GageFolder implements FolderInterface
{
    use IdentifiableTrait;
    use TimestampTrait;

    #[ORM\Column(nullable: true)]
    protected ?string $state = null;

    #[ORM\OneToOne(targetEntity: GageCredit::class, inversedBy: 'folder')]
    #[ORM\JoinColumn(name: 'credit_id', referencedColumnName: 'id')]
    protected ?GageCredit $credit = null;

    #[ORM\ManyToOne(targetEntity: Portfolio::class, inversedBy: 'gageCreditFolders')]
    #[ORM\JoinColumn(name: 'portfolio_id', referencedColumnName: 'id')]
    private ?Portfolio $portfolio = null;
    
    #[ORM\OneToMany(targetEntity: Attestation::class, mappedBy: 'folder', cascade: ['persist'])]
    private Collection $attestations;

    #[ORM\OneToMany(targetEntity: RenawalGageCredit::class, mappedBy: 'folder')]
    private Collection $renawaledCredits;

    public function __construct()
    {
        $this->attestations = new ArrayCollection();
        $this->renawaledCredits = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * @param Collection<int, AttestationInterface> $attestations
     * @return GageFolder
     */
    public static function create(Collection $attestations): GageFolder
    {
        $folder = new GageFolder;
        foreach ($attestations as $attestation) {
            $folder->addAttestation($attestation);
        }
        
        return $folder;
    }

    /**
     * @return Collection<int, AttestationInterface>
     */
    public function getAttestations(): Collection
    {
        return $this->attestations;
    }

    public function addAttestation(AttestationInterface $attestation): self
    {
        if (!$this->attestations->contains($attestation)) {
            $this->attestations->add($attestation);
        }

        return $this;
    }

    public function removeAttestation(AttestationInterface $attestation): self
    {
        if ($this->attestations->contains($attestation)) {
            $this->attestations->removeElement($attestation);
        }

        return $this;
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

    public function getPortfolio(): ?Portfolio
    {
        return $this->portfolio;
    }

    public function setPortfolio(Portfolio $portfolio): self
    {
        $this->portfolio = $portfolio;
        return $this;
    }
}