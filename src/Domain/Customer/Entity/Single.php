<?php

namespace App\Domain\Customer\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
class Single extends Situation
{
    public function getId(): int
    {
        return $this->id;
    }
}