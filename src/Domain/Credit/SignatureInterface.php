<?php

namespace App\Domain\Credit;

interface SignatureInterface 
{
    public function getLable(): string;
    public function setLabel(string $label): self;
}