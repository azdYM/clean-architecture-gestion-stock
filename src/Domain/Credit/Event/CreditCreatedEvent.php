<?php


namespace App\Domain\Credit\Event;

use App\Domain\Credit\CreditInterface;
use App\Domain\Mounting\Entity\MountingCreditFolderService;

class CreditCreatedEvent
{
    public function __construct(private CreditInterface $credit,){}

    public function getCredit(): CreditInterface
    {
        return $this->credit;
    }

    public function getCreditCreationServiceName(): string
    {
        return $this->getMountingService()
            ->getServiceName()
        ;
    }

    public function getAgencyId(): string
    {
        return $this->getMountingService()
            ->getAgency()  
            ->getId()
        ; 
    }
    
    private function getMountingService(): MountingCreditFolderService
    {
        return $this->credit
            ->getFolder()
            ->getMountingFolderService()
        ;
    }
}