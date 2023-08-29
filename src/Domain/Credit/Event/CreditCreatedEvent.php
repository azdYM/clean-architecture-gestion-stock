<?php


namespace App\Domain\Credit\Event;

use App\Domain\Credit\CreditInterface;
use App\Domain\Mounting\Entity\MountingCreditFolderService;
use App\Domain\Mounting\Entity\MountingSection;

class CreditCreatedEvent
{
    public function __construct(
        private CreditInterface $credit, 
        private MountingSection $section
    ){}

    public function getCredit(): CreditInterface
    {
        return $this->credit;
    }

    public function getCreditCreationServiceName(): string
    {
        return $this->creditCreationService()->getServiceName();
    }

    public function getAgencyLabel(): string
    {
        return $this->creditCreationService()
            ->getAgency()  
            ->getLabel()
        ; 
    }

    private function creditCreationService(): MountingCreditFolderService
    {
        return $this->credit
            ->getCreditAgent()
            ->getMountingSection()
            ->getMountingFolderService()
        ;
    }
}