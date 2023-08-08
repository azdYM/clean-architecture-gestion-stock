<?php

namespace App\Domain\Application;

interface DataFromADBankingInterface
{
    public function generateDataFromADBanking(): array;
}