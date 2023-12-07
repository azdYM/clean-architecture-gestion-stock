<?php

namespace App\Domain\Contract\Components;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use App\Domain\Application\Entity\IdentifiableTrait;

#[Entity(repositoryClass: SignatureLabelRepository::class)]
class SignatureLabel
{
    use IdentifiableTrait;
    use ContractTypeTrait;

    #[ORM\Column]
    private ?string $label;

    public function getLable(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }
}