<?php

namespace App\Domain\Contract\Components;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\Application\Entity\IdentifiableTrait;
use App\Domain\Contract\Components\ParameterInDescription;
use App\Domain\Contract\Components\GeneralContentRepository;

#[ORM\Entity(repositoryClass: GeneralContentRepository::class)]
class GeneralContent
{
    use IdentifiableTrait;

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