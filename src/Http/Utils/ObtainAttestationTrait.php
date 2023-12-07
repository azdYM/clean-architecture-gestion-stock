<?php

namespace App\Http\Utils;

use App\Domain\Garantee\Entity\GaranteeAttestation;
use App\Domain\Garantee\Entity\Gold\GoldAttestation;
use App\Domain\Garantee\Repository\Gold\GoldAttestationRepository;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

trait ObtainAttestationTrait {

    public function getAttestation(int $id): GaranteeAttestation|null
    {
        if (empty($id)) {
            throw new NotFoundResourceException(
                "Aucun id n'a été saisit ! Veuillez s'il vous plait saisir un id"
            );
        }
        
        $repository = $this->getAttestationRepository(GoldAttestation::class);
        $attestation = $repository->find($id);
        
        if ($attestation === null) {
            // on peut apeller d'autre type d'attestation repository, 
            // a implémenter plus tard.
            // d'ailleur je dois eviter d'utiliser l'identifiant 
        }
        
        return $attestation;
    }

    public function getAttestationRepository(string $className): GoldAttestationRepository
    {
        return $this->em->getRepository($className);
    }
}