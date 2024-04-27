<?php

namespace App\Http\Utils;

use App\Domain\Garantee\Entity\GaranteeAttestation;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

trait ObtainAttestationTrait {

    public function getAttestation(int $id): GaranteeAttestation
    {
        /** @var GaranteeAttestation $attestation */
        $attestation = $this->em->find(GaranteeAttestation::class, $id);

        if ($attestation === null) {
            throw new NotFoundResourceException(sprintf("L'attestation %s n'existe pas", $id));
        }
        
        return $attestation;
    }
}