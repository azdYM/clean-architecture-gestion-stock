<?php

namespace App\Domain\Application;

use App\Domain\Credit\SignatureInterface;

interface LabelContainSignatureCreator
{
    public function setContractType(string $type): self;
    public function create(): SignatureInterface;
}