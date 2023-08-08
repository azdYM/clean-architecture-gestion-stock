<?php

namespace App\Domain\Credit;

use Doctrine\Common\Collections\Collection;
use App\Domain\Credit\Entity\Contract\ParameterInDescription;

interface ParameterInDescriptionInterface
{
    /**
     * @return Collection<int, ParameterInDescription>
     */
    public function getParametersInDescription(): Collection;
    public function addParameterInDescription(ParameterInDescription $parameter): self;
}