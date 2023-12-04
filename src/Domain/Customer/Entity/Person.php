<?php

namespace App\Domain\Customer\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\Application\Entity\TimestampTrait;
use App\Domain\Application\Entity\IdentifiableTrait;
use App\Domain\Customer\Repository\PersonRepository;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'discr', type: 'string')]
#[ORM\DiscriminatorMap([
    'person' => Person::class, 
    'individual' => Individual::class, 
    'corporate' => Corporate::class
])]
class Person
{
    use IdentifiableTrait;
    use TimestampTrait;

    #[ORM\Column(name: 'name', length: 255)]
    protected ?string $name = null;

    /**
     * Plusieurs personnes peuvent avoir plusieurs adresses
     * 
     * @var Collection<int, Location>
     */
    #[ORM\JoinTable(name: 'locations_persons')]
    #[ORM\JoinColumn(name: 'person_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'location_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Location::class)]
    protected Collection $locations;

    /**
     * @var Collection<int, Contact>
     */
    #[ORM\JoinTable(name: 'contacts_persons')]
    #[ORM\JoinColumn(name: 'person_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'contact_id', referencedColumnName: 'id', unique: true)]
    #[ORM\ManyToMany(targetEntity: Contact::class)]
    protected Collection $contacts;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
        $this->contacts = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     *
     * @return Collection<Contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->contains($contact)) {
            $this->contacts->remove($contact->getId());
        }

        return $this;
    }

    /**
     *
     * @return Collection<Location>
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations->add($location);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->contacts->contains($location)) {
            $this->contacts->remove($location->getId());
        }

        return $this;
    }
}