<?php

namespace App\Http\Api\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Domain\Customer\Entity\Client;
use App\Domain\Customer\Entity\Corporate;
use App\Domain\Customer\Entity\Individual;
use App\Domain\Customer\Repository\CorporateRepository;
use App\Domain\Customer\Repository\IndividualRepository;
use App\Http\Api\DTO\Customer\ClientDTO;
use App\Http\Api\DTO\Customer\Corporate as CorporateDto;
use App\Http\Api\DTO\Customer\Individual as IndividualDto;
use App\Http\Api\DTO\Customer\SearchClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SearchClientStateProvider implements ProviderInterface
{
    public function __construct
    (
        private HttpClientInterface $clientHttp,
        private EntityManagerInterface $em,
    ){}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $folio = $uriVariables['folio'] ?? null;
        $client = $this->getClient($folio);

        if ($client === null) {
            $client = $this->getClientFromSIG($folio);
        }

        //dd($this->mapEntityToDto($client));
        return $this->mapEntityToDto($client);
    }

    /**
     * Obtenir le client depuis la base de données de ce projet
     *
     * @param integer $folio
     * @return Client|null
     */
    private function getClient(int $folio): Client|null
    {
        if (empty($folio)) {
            throw new NotFoundResourceException(
                "Aucun folio n'a été saisit ! Veuillez s'il vous plait saisir un folio"
            );
        }

        $repository = $this->getRepository(Individual::class);
        $client = $repository->findIndividualByFolio($folio);

        if ($client === null) {
            $repository = $this->getRepository(Corporate::class);
            $client = $repository->findCorporateByFolio($folio);
        }
        
        return $client;
    }

    private function getClientFromSIG($folio)
    {
        $sigUrl = "..../$folio";
        $client = $this->clientHttp->request('POST', $sigUrl, []);
        return $client;
    }

    private function getRepository(string $className): IndividualRepository|CorporateRepository
    {
        return $this->em->getRepository($className);
    }

    /**
     * Hydrate l'entité en dto
     *
     * @param Client $client
     * @param boolean $persisted spécifie si l'entité est persisté dans notre base de donnée ou non
     * @return SearchClient
     */
    private function mapEntityToDto(Client $client, bool $persisted = true): SearchClient
    {
        $searchClient = new SearchClient();
        $searchClient->folio = $client->getFolio();
        $searchClient->persisted = $persisted;
        $searchClient->client = $this->mapClientEntityToDto($client);

        if ($client instanceof Individual) {
            $searchClient->clientType = Individual::class;
        }

        elseif ($client instanceof Corporate) {
            $searchClient->clientType = Corporate::class;
        }

        else {
            throw new \LogicException();
        }
        
        return $searchClient;
    }

    private function mapClientEntityToDto(Client $client): ClientDTO
    {
        // Je me repete comme ça parceque de toute façon, cette methode n'est pas 
        // prevu pour être dans cette classe

        if ($client instanceof Individual) {
            $clientDto = new IndividualDto();
            $clientDto->name = $client->getName();
            $clientDto->nickname = $client->getNickname();
            $clientDto->gender = $client->getGender();
        }

        elseif ($client instanceof Corporate) {
            $clientDto = new CorporateDto();
            $clientDto->name = $client->getName();
            $clientDto->legalForm = $client->getLegalForm();
            $clientDto->activityDomain = $client->getActivityDomain();
            $clientDto->comericialRegistry = $client->getComercialRegistry();
        }

        else {
            throw new \LogicException();
        }

        $clientDto->folio = $client->getFolio();
        $clientDto->id = $client->getId();

        foreach($client->getContacts() as $contact)
        {
            $clientDto->contacts[] = $contact;
        }

        foreach($client->getLocations() as $location)
        {
            $clientDto->locations[] = $location;
        }

        return $clientDto;
    }
}