<?php

namespace App\Domain\Application\Entity;

use Doctrine\ORM\Mapping as ORM;

trait IdentifiableTrait
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    protected ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

}