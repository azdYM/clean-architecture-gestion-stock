<?php

namespace App\Http\Utils;

use Doctrine\Common\Collections\Collection;
use App\Domain\Garantee\Entity\GaranteeAttestation;
use App\Http\Api\DTO\Garantee\Attestation as GaranteeAttestationDto;

trait MapGaranteeAttestationEntityToDto 
{
    use MapClientEntityToDto;

    private function addCollectionAttestationsToDto(array $attestations, array &$dtoCollectionAttestation) 
    {
        for ($i=0; $i < count($attestations); $i++) { 
            $dtoCollectionAttestation[$i] = $this->mapGaranteeAttestationToDto($attestations[$i]);
        }
    }

    private function mapGaranteeAttestationToDto(GaranteeAttestation $attestation): GaranteeAttestationDto
    {
        $dtoAttestation = new GaranteeAttestationDto();
        $dtoAttestation->id = $attestation->getId();
        $this->addItemsToDtoAttestation($attestation->getItems(), $dtoAttestation);
        $clientDto = $this->mapClientEntityToDto($attestation->getClient());
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

    private function addItemsToDtoAttestation(Collection $items, GaranteeAttestationDto $attestation)
    {
        foreach($items as $key => $item) {
            $attestation->items[$key] = $item;
        }
    }

    private function canMountCredit(GaranteeAttestation $attestation) {
        $isApproved = $attestation->getCurrentPlace() === GaranteeAttestation::ATTESTATION_APPROVED;
        $isAlreadyUsed = $attestation->getFolder() !== null;

        return $isApproved && !$isAlreadyUsed;
    }
}