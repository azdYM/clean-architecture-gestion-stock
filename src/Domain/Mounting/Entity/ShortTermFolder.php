<?php

namespace App\Domain\Mounting\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Mounting\Repository\ShortTermFolderRepository;

#[ORM\Entity(repositoryClass: ShortTermFolderRepository::class)]
class ShortTermFolder extends Folder
{
    #[ORM\Id]
    #[ORM\GeneratedValue()]
    #[ORM\Column]
    protected ?int $id = null;

    public function getId(): int
    {
        return $this->id;
    }
}