<?php

namespace App\Domain\Contract\Components;

use Doctrine\ORM\Mapping as ORM;

trait ContractTypeTrait
{
    #[ORM\Column]
    private ?string $contractType = null;

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