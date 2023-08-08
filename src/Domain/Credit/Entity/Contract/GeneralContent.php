<?php

namespace App\Domain\Credit\Entity\Contract;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\Credit\ParameterInDescriptionInterface;
use App\Domain\Credit\Repository\GeneralContentRepository;
use App\Domain\Credit\Entity\Contract\ParameterInDescription;

#[ORM\Entity(repositoryClass: GeneralContentRepository::class)]
class GeneralContent implements ParameterInDescriptionInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'text')]
    private ?string $description;

    /**
     * @var Collection<int, ParameterInDescription>
     */
    #[ORM\OneToMany(targetEntity: ParameterInDescription::class, mappedBy: 'generalContent')]
    private Collection $parametersInDescription;

    public function __construct()
    {
        $this->parametersInDescription = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Collection<int, ParameterInDescription>
     */
    public function getParametersInDescription(): Collection
    {
        return $this->parametersInDescription;
    }

    public function addParameterInDescription(ParameterInDescription $parameter): self
    {
        if (!$this->parametersInDescription->contains($parameter)) {
            $this->parametersInDescription->add($parameter);
        }

        return $this;
    }
}