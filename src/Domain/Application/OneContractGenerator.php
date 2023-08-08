<?php

namespace App\Domain\Application;

use App\Domain\Credit\ContractInterface;

interface OneContractGenerator 
{
    public function setContractType(string $type): self;
    public function generate(): ContractInterface;
}