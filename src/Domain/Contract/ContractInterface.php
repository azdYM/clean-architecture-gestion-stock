<?php

namespace App\Domain\Contract;

interface ContractInterface
{    
    public function getArticles(): array;
    
    public function getLabelsForSignature(): array;
    
    public function getContent(): ?string;
}