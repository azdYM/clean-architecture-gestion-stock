<?php

namespace App\Domain\Employee\Service;

use App\Domain\Credit\CreditInterface;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Mounting\FolderInterface;
use App\Domain\Mounting\TargetCreditTrait;
use Doctrine\Common\Collections\Collection;
use App\Domain\Credit\Event\CreditCreatedEvent;
use App\Domain\Mounting\DTO\CreditRequirements;
use App\Domain\Mounting\DTO\FolderRequirements;
use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\Credit\Entity\ShortTerm\GageCredit;
use App\Domain\Credit\Service\CreditCreationServiceInterface;
use App\Domain\Mounting\Service\FolderMountingServiceInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class CreditMountingService 
{
    use TargetCreditTrait;

    public function __construct
    (
        private Employee $creditAgent, 
        private EventDispatcherInterface $event
    ){}

    public function mountFolder(
        FolderMountingServiceInterface $mountingService, FolderRequirements $requirements
    ): FolderInterface
    {
        return $mountingService->mount(
            $requirements->getAttestations(), 
            $requirements->getClient()->getPortfolio()
        );
    }

    public function createCredit(
        CreditCreationServiceInterface $service, CreditRequirements $requirements
    ): CreditInterface
    {
        $credit = $service->create($requirements, $this->creditAgent);
        $this->event->dispatch(new CreditCreatedEvent($credit, $this->creditAgent->getCurrentMountingSection()));
        return $credit;
    }

    public function generateContractsForGageCredit(GageCredit $credit): Collection
    {
        return new ArrayCollection();
    }

    public function renawalCredit(): void
    {
        // On verra plus tard
    }
}