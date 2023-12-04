<?php

namespace App\Http\Utils;

use App\Domain\Customer\Entity\Client;
use App\Domain\Customer\Entity\Corporate;
use App\Domain\Customer\Entity\Individual;
use App\Domain\Customer\Repository\CorporateRepository;
use App\Domain\Customer\Repository\IndividualRepository;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

trait ObtainClientTrait {

    /**
     * Obtenir le client depuis la base de données de ce projet
     *
     * @param integer $folio
     * @return Client|null
     */
    public function getClient(int $folio): Client|null
    {
        if (empty($folio)) {
            throw new NotFoundResourceException(
                "Aucun folio n'a été saisit ! Veuillez s'il vous plait saisir un folio"
            );
        }
        
        $repository = $this->getClientRepository(Individual::class);
        $client = $repository->findIndividualByFolio($folio);
        
        if ($client === null) {
            $repository = $this->getClientRepository(Corporate::class);
            $client = $repository->findCorporateByFolio($folio);
        }
        
        return $client;
    }

    public function getClientRepository(string $className): IndividualRepository|CorporateRepository
    {
        return $this->em->getRepository($className);
    }
}