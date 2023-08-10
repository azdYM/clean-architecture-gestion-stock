<?php

namespace App\Domain\Customer\Entity;

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
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue()]
    private ?int $id = null;

    /**
     * @var Collection<int, Situation>
     */
    #[ORM\OneToMany(targetEntity: Situation::class, mappedBy: 'matrimonialStatus', cascade: ['persist', 'remove'])]
    private Collection $situations;

    public function __construct()
    {
        $this->situations = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
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
}