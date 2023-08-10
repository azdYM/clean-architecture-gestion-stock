<?php

namespace App\Domain\Customer\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Customer\Entity\Location;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\Customer\Repository\CorporateRepository;

/**
 * Corporate représente les entités corporatives dans le système de gestion de crédits. 
 * Une entité corporative peut être une entreprise, une société, une organisation ou toute autre entité 
 * légale distincte des individus.
 */
#[ORM\Entity(repositoryClass: CorporateRepository::class)]
class Corporate extends Client
{
    #[ORM\Column(length: 255)]
    private ?string $legalForm = null;
    
    #[ORM\OneToOne(targetEntity:Location::class)]
    private ?Location $createdLocation;

    #[ORM\OneToOne(targetEntity:Location::class)]
    private ?Location $centralLocation;

    #[ORM\Column(length: 255)]
    private ?string $activityDomain = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $comericialRegistry = null;

    /**
     * @var Collection<int Person>
     */
    #[ORM\JoinTable(name: 'corporates_managers')]
    #[ORM\JoinColumn(name: 'corporate_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'manager_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Person::class)]
    private Collection $managers;

    public function __construct()
    {
        $this->managers = new ArrayCollection();
    }

    public function getLegalForm(): string
    {
        return $this->legalForm;
    }

    public function setLegalForm(string $legalForm): self
    {
        $this->legalForm = $legalForm;
        return $this;
    }

    public function getCreatedLocation(): Location
    {
        return $this->createdLocation;
    }

    public function setCreatedLocation(Location $createdLocation): self
    {
        $this->createdLocation = $createdLocation;
        return $this;
    }

    public function getCentralLocation(): Location
    {
        return $this->centralLocation;
    }

    public function setCentralLocation(Location $centralLocation): self
    {
        $this->centralLocation = $centralLocation;
        return $this;
    }

    public function getActivityDomain(): string
    {
        return $this->activityDomain;
    }

    public function setActivityDomain(string $activityDomain): self
    {
        $this->activityDomain = $activityDomain;
        return $this;
    }

    public function getComercialRegistry(): string
    {
        return $this->comericialRegistry;
    }

    public function setComercialRegistry(string $comercialRegistry): self
    {
        $this->comericialRegistry = $comercialRegistry;
        return $this;
    }

    public function getManagers(): Collection
    {
        return $this->managers;
    }

    public function addManager(Person $manager): self
    {
        if (!$this->managers->contains($manager)) {
            $this->managers->add($manager);
        }

        return $this;
    }
}