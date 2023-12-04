<?php

namespace App\Domain\Contract;

use App\Domain\Credit\SignatureInterface;

interface MakerSignatureContainLabels
{
    public function setContractType(string $type): self;
    
    public function generate(): SignatureInterface;
}