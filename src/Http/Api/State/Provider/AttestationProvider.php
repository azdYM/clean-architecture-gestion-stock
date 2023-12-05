<?php

namespace App\Http\Api\State\Provider;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Domain\Garantee\Entity\GaranteeAttestation;
use App\Http\Utils\MapGaranteeAttestationEntityToDto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class AttestationProvider implements ProviderInterface
{
    use MapGaranteeAttestationEntityToDto;

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
        $dtoAttestation = $this->mapGaranteeAttestationToDto($attestation);

        return $dtoAttestation;
    }

    private function getAllAttestations(): array
    {
        $attestations = $this->em->getRepository(GaranteeAttestation::class)->findAll();
        $dtoCollectionAttestation = [];

        $this->addCollectionAttestationsToDto($attestations, $dtoCollectionAttestation);

        return $dtoCollectionAttestation;
    }
}