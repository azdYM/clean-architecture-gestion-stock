<?php

namespace App\Domain\Mounting;

use Doctrine\Common\Collections\Collection;

/**
 * Un dossier qui implemente cette interface implique qu'on peut renouveler son credit associé à
 * plusieurs reprises. chaque crédit rénouvelé peut avoir la garantie du crédit de base
 * ou avoir une nouvelle garantie. Il peut être une diminution, une augmentation de la garantie
 * du crédit de base, ou il peut s'agir d'un transfert de garantie.
 */

interface RenawaledCreditInterface 
{
    public function getRenawaledCredits(): Collection;
}