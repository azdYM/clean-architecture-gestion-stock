<?php

namespace App\Domain\Mounting\Entity\ShortTerm;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Credit\CreditInterface;
use Doctrine\Common\Collections\Collection;
use App\Domain\Mounting\Entity\CreditFolder;
use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\Credit\Entity\ShortTerm\GageCredit;
use App\Domain\Garantee\Entity\GaranteeAttestation;
use App\Domain\Credit\Entity\ShortTerm\RenewalShortTermCredit;
use App\Domain\Mounting\Repository\ShortTerm\GageFolderRepository;

#[ORM\Entity(repositoryClass: GageFolderRepository::class)]
class GageFolder extends CreditFolder
{
    #[ORM\OneToOne(targetEntity: GageCredit::class, inversedBy: 'folder')]
    #[ORM\JoinColumn(name: 'credit_id', referencedColumnName: 'id')]
    protected ?GageCredit $credit = null;

    #[ORM\OneToMany(targetEntity: RenewalShortTermCredit::class, mappedBy: 'folder')]
    private Collection $renewedCredits;

    public function __construct()
    {
        parent::__construct();
        $this->renewedCredits = new ArrayCollection();
    }

    /**
     * @param Collection<int, GaranteeAttestation> $attestations
     * @return GageFolder
     */
    public static function create(Collection $attestations): GageFolder
    {
        $folder = new GageFolder;
        foreach ($attestations as $attestation) {
            $attestation->setFolder($folder);
            $folder->addAttestation($attestation);
        }
        
        return $folder;
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

    /**
     * @return Collection<int, RenewalShortTermCredit>
     */
    public function getRenewedCredits(): Collection
    {
        return $this->renewedCredits;
    }

    public function addRenewedCredit(RenewalShortTermCredit $renewedCredit): self
    {
        if (!$this->renewedCredits->contains($renewedCredit)) {
            $this->renewedCredits->add($renewedCredit);
        }

        return $this;
    }

    public function removeRenewedCredit(RenewalShortTermCredit $renewedCredit): self
    {
        if ($this->renewedCredits->contains($renewedCredit)) {
            $this->renewedCredits->add($renewedCredit);
        }

        return $this;
    }
}