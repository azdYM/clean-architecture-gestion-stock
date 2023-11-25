<?php

namespace App\Http\Api\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Domain\Customer\Entity\Client;
use App\Domain\Customer\Entity\Corporate;
use App\Domain\Customer\Entity\Individual;
use App\Http\Api\DTO\Customer\Client as ClientDTO;
use App\Http\Api\DTO\Customer\Corporate as CorporateDto;
use App\Http\Api\DTO\Customer\Individual as IndividualDto;
use App\Http\Api\DTO\Customer\SearchClient;
use App\Http\Utils\ObtainClientTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SearchClientStateProvider implements ProviderInterface
{
    use ObtainClientTrait;

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
            try {
                $client = $this->getClientFromSIG($folio);
            } catch (\Throwable $th) {
                throw new NotFoundHttpException(sprintf("Le folio %s n'existe pas", $folio), $th, 404);
            }
        }

        return $this->mapEntityToDto($client);
    }


    private function getClientFromSIG($folio)
    {
        $sigUrl = "..../$folio";
        $client = $this->clientHttp->request('POST', $sigUrl, []);
        return $client;
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