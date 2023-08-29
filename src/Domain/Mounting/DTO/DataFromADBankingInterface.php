<?php

namespace App\Domain\Mounting\DTO;

interface DataFromADBankingInterface
{
    public function generateDataFromADBanking(): array;
}