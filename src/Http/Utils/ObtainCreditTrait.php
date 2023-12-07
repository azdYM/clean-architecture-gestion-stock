<?php

namespace App\Http\Utils;

use App\Domain\Credit\Entity\Credit;
use App\Domain\Credit\Entity\ShortTerm\GageCredit;
use App\Domain\Credit\Repository\ShortTerm\GageCreditRepository;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

trait ObtainCreditTrait {

    public function getCredit(int $id): Credit
    {
        if (empty($id)) {
            throw new NotFoundResourceException(
                "Aucun id n'a été saisit ! Veuillez s'il vous plait saisir un id"
            );
        }
        
        $repository = $this->getCreditRepository(GageCredit::class);
        $credit = $repository->find($id);
        
        if ($credit === null) {
            // on peut apeller d'autre type de credit repository, 
            // a implémenter plus tard.
            // d'ailleur je dois eviter d'utiliser l'identifiant 
        }

        if ($credit === null) {
            throw new NotFoundResourceException(
                sprintf("Aucun crédit n'est associé à l'identifiant %s", 
                $id
            ));
        }
        
        return $credit;
    }

    public function getCreditRepository(string $className): GageCreditRepository
    {
        return $this->em->getRepository($className);
    }
}