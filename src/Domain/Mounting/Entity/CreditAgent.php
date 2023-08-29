<?php

namespace App\Domain\Mounting\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Employee\Employee;
use App\Domain\Credit\CreditInterface;
use App\Domain\Mounting\FolderInterface;
use App\Domain\Mounting\TargetCreditTrait;
use Doctrine\Common\Collections\Collection;
use App\Domain\Credit\Gage\Entity\GageCredit;
use App\Domain\Credit\Event\CreditCreatedEvent;
use App\Domain\Mounting\DTO\CreditRequirements;
use App\Domain\Mounting\DTO\FolderRequirements;
use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\Mounting\WorkingCreditMountingSectionTrait;
use App\Domain\Credit\Service\CreditCreationServiceInterface;
use App\Domain\Mounting\Service\FolderMountingServiceInterface;

#[ORM\Entity]
class CreditAgent extends Employee
{
    use WorkingCreditMountingSectionTrait;
    use TargetCreditTrait;

    #[ORM\ManyToOne(targetEntity: MountingSection::class, inversedBy: 'creditAgents', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'mounting_section_id', referencedColumnName: 'id')]
    private ?MountingSection $mountingSection = null;

    public function mountFolder(
        FolderMountingServiceInterface $mountingService, 
        FolderRequirements $requirements
    ): FolderInterface
    {
        return $mountingService->mount(
            $requirements->getAttestations(), 
            $requirements->getClient()->getPortfolio()
        );
    }

    public function createCredit(
        CreditCreationServiceInterface $service, 
        CreditRequirements $requirements
    ): CreditInterface
    {
        $credit = $service->create($requirements, $this);
        $this->event->dispatch(new CreditCreatedEvent($credit, $this->getMountingSection()));
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