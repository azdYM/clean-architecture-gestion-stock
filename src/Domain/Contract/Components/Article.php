<?php

namespace App\Domain\Contract\Components;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\Contract\Components\ArticleRepository;
use App\Domain\Contract\Components\ParameterInDescription;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $title = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    /**
     * @var Collection<int, ParameterInDescription>
     */
    #[ORM\OneToMany(targetEntity: ParameterInDescription::class, mappedBy: 'article')]
    private Collection $parametersInDescription;

    public function __construct()
    {
        $this->parametersInDescription = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
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

    public function setArticle(string $title, string $description): self
    {
        $this->title = $title;
        $this->description = $description;
        return $this;
    }
}