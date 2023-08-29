<?php

namespace App\Domain\Mounting\DTO;

use App\Domain\Garantee\AttestationInterface;
use App\Domain\Mounting\DTO\DataFromADBankingInterface;

class CreditRequirements implements DataFromADBankingInterface
{
    public int $capital;

    public int $interest;

    public int $duration;

    public \DateTimeInterface $startedAt;

    public \DateTimeInterface $endAt;

    public int $weight;

    public int $value;

    public string $code;

    public AttestationInterface $attestation;

    public int $idADBankingFolder;

    public function generateDataFromADBanking(): array
    {
        // Appeler un api pour recupérer les données du SIG
        return [];
    }
}