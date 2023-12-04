<?php

namespace App\Domain\Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait IdentifiableTrait
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    #[Groups(['General:read', 'Identifiant:read'])]
    protected ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

}