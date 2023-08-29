<?php

namespace App\Domain\Credit\Service;

use App\Domain\Credit\CreditInterface;
use App\Domain\Credit\Gage\Entity\GageCredit;
use App\Domain\Employee\Employee;
use App\Domain\Mounting\DTO\CreditRequirements;
use App\Domain\Mounting\Entity\GageFolder;

class GageCreditCreationService implements CreditCreationServiceInterface
{
    public function __construct(private GageFolder $folder)
    {}

    public function create(CreditRequirements $requirements, Employee $creditAgent): CreditInterface
    {
        $credit = (new GageCredit)
            ->setAttestation($requirements->attestation)
            ->setCapital($requirements->capital)
            ->setInterest($requirements->interest)
            ->setFolder($this->folder)
            ->setStartedAt($requirements->startedAt)
            ->setEndAt($requirements->endAt)
            ->setDuration($requirements->duration)
            ->setCode($requirements->code)
            ->setCreditAgent($creditAgent)
            ->setIdADBankingFolder($requirements->idADBankingFolder)
        ;
        
        $this->folder->setCredit($credit);
        return $credit;
    }
}