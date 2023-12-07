<?php

namespace App\Domain\Contract;

use App\Domain\Contract\Entity\Contract;
use App\Domain\Contract\Components\GeneralContent;


interface MakerContentInterface 
{
    public function setContract(Contract $type): self;
    public function generate(): string ;
}