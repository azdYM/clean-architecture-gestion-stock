<?php

namespace App\Domain\Contract\Components;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Application\Entity\IdentifiableTrait;
use App\Domain\Contract\Components\GeneralContentRepository;

#[ORM\Entity(repositoryClass: GeneralContentRepository::class)]
class GeneralContent
{
    use IdentifiableTrait;
    #[ORM\Column(unique: true)]
    private ?string $contractType = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getContractType(): ?string
    {
        return $this->contractType;
    }

    public function setContractType(string $contractType): self
    {
        $this->contractType = $contractType;
        return $this;
    }
}