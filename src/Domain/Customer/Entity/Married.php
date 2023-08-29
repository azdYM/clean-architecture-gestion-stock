<?php

namespace App\Domain\Customer\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
/**
 * Cette classe represente la situation mariée d'une personne. Une personne peut avoir plusieurs epoux(ses)
 */
#[ORM\Entity]
class Married extends Situation
{
    /**
     * @var Collection<int, Person>
     */
    #[ORM\JoinTable(name: 'married_person')]
    #[ORM\JoinColumn(name: 'married_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'spouse_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Person::class)]
    private Collection $spouses;

    public function __construct()
    {
        parent::__construct();
        $this->spouses = new ArrayCollection();
    }

    public function getSpouses(): Collection
    {
        return $this->spouses;
    }

    public function addSpouse(Person $person): self
    {
        if (!$this->spouses->contains($person)) {
            $this->spouses->add($person);
        }

        return $this;
    }

    public function removeSpouse(Person $person): self
    {
        if ($this->spouses->contains($person)) {
            $this->spouses->remove($person->getId());
        }

        return $this;
    }
}