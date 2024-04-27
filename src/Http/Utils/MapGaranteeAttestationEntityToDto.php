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
        for ($i = 0; $i < count($attestations); $i++) { 
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
        $dtoAttestation->canEdit = $this->attestationGage->can($attestation, 'validate_evaluation');
        $dtoAttestation->canPrint = $this->attestationGage->getMarking($attestation)->has('approved');
        $dtoAttestation->evaluator = $attestation->getEvaluator();
        $dtoAttestation->evaluatorDescription = $attestation->getEvaluatorDescription();
        $dtoAttestation->idCreditTypeTargeted = $attestation->getCreditTypeTargeted()->getId();
        $dtoAttestation->updatedAt = $attestation->getUpdatedAt();
        $dtoAttestation->canMountCredit = $this->canMountCredit($attestation);
        
        $dtoAttestation->currentPlace = $this->hasRejected($attestation) 
            ? GaranteeAttestation::ATTESTATION_REJECTED : $attestation->getCurrentPlace();

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

    private function hasRejected(GaranteeAttestation $attestation)
    {
        $rejected = count($attestation->getRejections()) > 0;
        $currentPlaceIsEvaluated = $attestation->getCurrentPlace() ===  GaranteeAttestation::ATTESTATION_EVALUATED;
        
        return $rejected && $currentPlaceIsEvaluated;
    }
}