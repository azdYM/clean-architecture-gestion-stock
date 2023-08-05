<?php

namespace App\Domain\Garantee;

/**
 * L'interface GaranteeInterface représente un contrat pour les différentes garanties 
 * associées aux crédits dans le système.
*/
interface GaranteeInterface
{
    public function calculateValue(): void;
    public function getValue(): int|float;
}