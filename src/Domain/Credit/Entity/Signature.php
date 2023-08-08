<?php

namespace App\Domain\Credit\Entity;

use App\Domain\Credit\Repository\SignatureRepository;
use App\Domain\Credit\SignatureInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;

#[Entity(repositoryClass: SignatureRepository::class)]
class Signature implements SignatureInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column]
    private ?string $label;

    public function getId()
    {
        return $this->id;
    }

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