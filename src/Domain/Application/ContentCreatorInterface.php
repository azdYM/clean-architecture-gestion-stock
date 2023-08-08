<?php

namespace App\Domain\Application;

use App\Domain\Credit\Entity\Contract\GeneralContent;

interface ContentCreatorInterface 
{
    public function setContractType(string $type): self;
    public function create(): GeneralContent ;
}