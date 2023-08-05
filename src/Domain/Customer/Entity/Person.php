<?php

namespace App\Domain\Customer\Entity;

use DateTimeInterface;
use App\Domain\Customer\ClientInterface;
use App\Domain\Customer\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;


#[ORM\Entity(repositoryClass: PersonRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'discr', type: 'string')]
#[ORM\DiscriminatorMap(['person' => Person::class, 'individual' => Individual::class, 'corporate' => Corporate::class])]
abstract class Person implements ClientInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue()]
    protected ?int $id = null;

    #[ORM\Column(type: 'integer', unique: true)]
    protected ?int $folio = null;

    #[ORM\Column(name: 'name', length: 255)]
    protected ?string $name = null;

    #[ORM\Column(name: 'created_at', type: 'datetime')]
    protected ?DateTimeInterface $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime')]
    protected ?DateTimeInterface $updatedAt;

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
    protected ?array $contacts = null;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
        $this->contacts = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
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

    public function getFolio(): ?int
    {
        return $this->folio;
    }

    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContacts(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
        }

        return $this;
    }

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
}