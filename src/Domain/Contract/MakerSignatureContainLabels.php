<?php

namespace App\Domain\Contract;

use App\Domain\Contract\Entity\Contract;

interface MakerSignatureContainLabels
{
    public function setContract(Contract $type): self;    
    
    public function generate(): array;
}