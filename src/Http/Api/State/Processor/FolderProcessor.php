<?php

namespace App\Http\Api\State\Processor;

use ApiPlatform\Metadata\Operation;
use App\Http\Api\DTO\Mounting\Folder;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\Domain\Employee\Service\CreditMountingService;
use App\Domain\Mounting\DTO\FolderRequirements;
use App\Domain\Mounting\Service\GageFolderMountingService;
use App\Http\Utils\ObtainAttestationTrait;
use App\Http\Utils\ObtainClientTrait;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class FolderProcessor implements ProcessorInterface
{
    use ObtainClientTrait;
    use ObtainAttestationTrait;

    public function __construct(
        private EntityManagerInterface $em,
        private EventDispatcherInterface $event,
        private Security $security
    ){}
    
    /**
     * Undocumented function
     *
     * @param Folder $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $client = $this->getClient($data->clientFolio);
        
        if ($client === null) {
            throw new NotFoundResourceException(
                sprintf("Il n'existe aucun client avec le folio %s", 
                $data->clientFolio
            ));
        }

        $folderRequirements = (new FolderRequirements())
            ->setClient($client)
        ;

        if (\is_array($data->attestations)) {
            foreach ($data->attestations as $attestation) {
                $findAttestation = $this->getAttestation($attestation->id);
                if ($findAttestation === null) {
                    throw new NotFoundResourceException(
                        sprintf("Il n'existe aucune attestation avec l'id %s", 
                        $attestation->id
                    ));
                }

                if ($findAttestation->getClient() !== $client) {
                    throw new \LogicException(
                        sprintf("L'attestation %s n'appartient pas au client qui a le folio %s",
                        $attestation->id, $client->getFolio()
                    ));
                }

                $folderRequirements->addAttestation($findAttestation);
            }
        }
        
        $service = new CreditMountingService($this->security->getUser(), $this->event);
        $folder = $service->mountFolder(new GageFolderMountingService, $folderRequirements);
        $this->em->persist($folder);
        $this->em->flush();

        return $folder;
    }
}