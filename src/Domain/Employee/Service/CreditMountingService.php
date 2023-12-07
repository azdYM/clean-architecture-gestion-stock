<?php

namespace App\Domain\Employee\Service;

use App\Domain\Contract\Entity\DeathSolidarityContract;
use App\Domain\Contract\Entity\GageContract;
use App\Domain\Contract\MakerArticlesInterface;
use App\Domain\Contract\MakerContentInterface;
use App\Domain\Contract\MakerSignatureContainLabels;
use App\Domain\Credit\Entity\Credit;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Mounting\FolderInterface;
use App\Domain\Mounting\TargetCreditTrait;
use Doctrine\Common\Collections\Collection;
use App\Domain\Credit\Event\CreditCreatedEvent;
use App\Domain\Mounting\DTO\CreditRequirements;
use App\Domain\Mounting\DTO\FolderRequirements;
use Doctrine\Common\Collections\ArrayCollection;
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
        $folder = $mountingService->mount(
            $requirements->getAttestations(), 
            $requirements->getClient()->getPortfolio()
        );

        $folder->setMountingFolderService(
            $this->creditAgent->getCurrentMountingSection()->getMountingFolderService()
        );

        return $folder;
    }

    public function createCredit(
        CreditCreationServiceInterface $service, CreditRequirements $requirements
    ): Credit
    {
        $credit = $service->create($requirements, $this->creditAgent);
        $this->event->dispatch(new CreditCreatedEvent($credit));
        return $credit;
    }

    public function generateContractsForGageCredit(
        Credit $credit,
        MakerContentInterface $makerContent,
        MakerArticlesInterface $makerArticle,
        MakerSignatureContainLabels $makerSignatureContainLabels
    ): Collection
    {
        $contracts = new ArrayCollection();
        $gageContract = (new GageContract)
            ->generateAndSetContent($makerContent)
            ->generateAndSetArticles($makerArticle)
            ->generateAndSetLabelsForSignature($makerSignatureContainLabels)
        ;

        // $deathSolidarityContract = (new DeathSolidarityContract)
        //     ->generateAndSetArticles($makerArticle)
        //     ->generateAndSetGeneralContent($makerContent)
        //     ->generateAndSetLabelsForSignature($makerSignatureContainLabels)
        // ;
        
        $contracts->add($gageContract);
        $credit->addContract($gageContract);

        // $contracts->add($deathSolidarityContract);
        //$credit->addContract($deathSolidarityContract);

        return $contracts;
    }

    public function renawalCredit(): void
    {
        // On verra plus tard
    }
}