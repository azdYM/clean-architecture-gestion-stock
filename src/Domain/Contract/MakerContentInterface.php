<?php

namespace App\Domain\Contract;

use App\Domain\Credit\Entity\Contract\GeneralContent;

interface MakerContentInterface 
{
    public function setContractType(string $type): self;
    public function generate(): GeneralContent ;
}