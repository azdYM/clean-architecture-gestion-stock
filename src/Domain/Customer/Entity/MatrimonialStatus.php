<?php

namespace App\Domain\Customer\Entity;

use App\Domain\Application\Entity\IdentifiableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Le statut matrimonial fait référence à l'état civil d'une personne.nIl s'agit d'une indication légale qui 
 * détermine si une personne est célibataire, mariée, divorcée, séparée ou veuve. 
 * Une personne peut être dans plusieurs sitatuations. A la demande d'une credit, on ajoute une nouvelle situation
 * sauf si rien n'a changé depuis le dérnier crédit.
 */
#[ORM\Entity()]
class MatrimonialStatus
{
    use IdentifiableTrait;

    /**
     * @var Collection<int, Situation>
     */
    #[ORM\OneToMany(
        targetEntity: Situation::class, 
        mappedBy: 'matrimonialStatus', 
        cascade: ['persist', 'remove']
    )]
    private Collection $situations;

    public function __construct()
    {
        $this->situations = new ArrayCollection();
    }

    /**
     * @var Collection<int, Situation>
     */
    public function getSituations(): Collection
    {
        return $this->situations;
    }

    public function getLastSituation(): Situation
    {
        return $this->situations->last();
    }

    public function addSituation(Situation $situation): self
    {
        if (!$this->situations->contains($situation)) {
            $this->situations->add($situation);
        }

        return $this;
    }

    public function removeSituation(Situation $situation): self
    {
        if ($this->situations->contains($situation)) {
            $this->situations->remove($situation->getId());
        }

        return $this;
    }
}