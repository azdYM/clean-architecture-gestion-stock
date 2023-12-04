<?php

namespace App\Domain\Contract;

use App\Domain\Contract\Components\GeneralContent;


interface MakerContentInterface 
{
    public function setContractType(string $type): self;
    public function generate(): GeneralContent ;
}