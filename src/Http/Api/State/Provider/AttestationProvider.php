<?php

namespace App\Http\Api\State\Provider;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Domain\Customer\Entity\Client;
use App\Domain\Customer\Entity\Corporate;
use App\Domain\Customer\Entity\Individual;
use App\Domain\Garantee\Entity\Attestation;
use App\Domain\Garantee\Entity\GaranteeAttestation;
use App\Domain\Garantee\Entity\Gold\GoldAttestation;
use App\Http\Api\DTO\Customer\Client as DTOClient;
use App\Http\Api\DTO\Garantee\Attestation as DTOAttestation;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class AttestationProvider implements ProviderInterface
{
    public function __construct
    (
        private WorkflowInterface $attestationGage,
        private EntityManagerInterface $em
    ){}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof CollectionOperationInterface) {
            return $this->getAllAttestations();
        }

        $idAttestation = $uriVariables['id'];
        /** @var GaranteeAttestation $attestation */
        $attestation = $this->em->find(GaranteeAttestation::class, $idAttestation);
        $dtoAttestation = $this->mapEntityToDto($attestation);

        return $dtoAttestation;
    }

    private function getAllAttestations(): array
    {
        $attestations = $this->em->getRepository(GaranteeAttestation::class)->findAll();
        $dtoCollectionAttestation = [];

        for ($i=0; $i < count($attestations); $i++) { 
            $dtoCollectionAttestation[$i] = $this->mapEntityToDto($attestations[$i]);
        }

        return $dtoCollectionAttestation;
    }

    private function mapEntityToDto(GoldAttestation $attestation): DTOAttestation
    {
        $dtoAttestation = new DTOAttestation();
        $dtoAttestation->id = $attestation->getId();
        $this->addItemsToDtoAttestation($attestation->getItems(), $dtoAttestation);
        $clientDto = $this->mapClientEntityToClientDto($attestation->getClient());
        $dtoAttestation->client = $clientDto;
        $dtoAttestation->canUpdate = $this->attestationGage->can($attestation, 'evaluate');
        $dtoAttestation->currentPlace = $attestation->getCurrentPlace();
        $dtoAttestation->evaluator = $attestation->getEvaluator();
        $dtoAttestation->evaluatorDescription = $attestation->getEvaluatorDescription();
        $dtoAttestation->idCreditTypeTargeted = $attestation->getCreditTypeTargeted()->getId();
        $dtoAttestation->updatedAt = $attestation->getUpdatedAt();
        $dtoAttestation->canMountCredit = $this->canMountCredit($attestation);
        
        return $dtoAttestation;
    }

    private function addItemsToDtoAttestation(Collection $items, DTOAttestation $attestation)
    {
        foreach($items as $key => $item) {
            $attestation->items[$key] = $item;
        }
    }

    private function mapClientEntityToClientDto(Client $client): DTOClient
    {
        $dtoClient = new DTOClient;
        $dtoClient->name = $client->getName();
        $dtoClient->folio = $client->getFolio();
        $this->setLocationsDto($dtoClient, $client->getLocations());
        $this->setContactsDto($dtoClient, $client->getContacts());
        

        if ($client instanceof Individual) {
            $dtoClient->nin = $client->getNin();
            $dtoClient->gender = $client->getGender();
            $dtoClient->nickname = $client->getNickname();
            $dtoClient->birthDay = $client->getBirthDay();
            $dtoClient->birthLocation = $client->getBirthLocation();
        } 

        else if ($client instanceof Corporate) {
            $dtoClient->legalForm = $client->getLegalForm();
            $dtoClient->activityDomain = $client->getActivityDomain();
            $dtoClient->comericialRegistry = $client->getComercialRegistry();
        }
        
        return $dtoClient;
    }

    private function setLocationsDto(DTOClient $client, Collection $locations) {
        foreach($locations as $key => $location) {
            $client->locations[$key] = $location;
        }
    }

    private function setContactsDto(DTOClient $client, Collection $contacts) {
        foreach($contacts as $key => $contact) {
            $client->contacts[$key] = $contact;
        }
    }

    private function canMountCredit(GaranteeAttestation $attestation) {
        $isApproved = $attestation->getCurrentPlace() === GaranteeAttestation::ATTESTATION_APPROVED;
        $isAlreadyUsed = $attestation->getFolder() !== null;

        return $isApproved && !$isAlreadyUsed;
    }
}