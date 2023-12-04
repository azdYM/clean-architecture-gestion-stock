<?php 

namespace App\Domain\Customer\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Domain\Application\Entity\IdentifiableTrait;
use App\Domain\Customer\Repository\LocationRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
#[UniqueEntity(
    fields: ['region', 'city', 'neighborhood'], 
    message: 'Cette location existe déjà dans la base de donnée'
)]
class Location 
{
    use IdentifiableTrait;
    
    #[ORM\Column(length: 100)]
    #[Groups(['Location:read'])]
    private ?string $region = null;

    #[ORM\Column(length: 100)]
    #[Groups(['Location:read'])]
    private ?string $city = null;

    #[ORM\Column(length: 100)]
    #[Groups(['Location:read'])]
    private ?string $neighborhood = null;

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getNeighborhood(): string
    {
        return $this->neighborhood;
    }

    public function setNeighborhood(string $neighborhood): self
    {
        $this->neighborhood = $neighborhood;
        return $this;
    }
}