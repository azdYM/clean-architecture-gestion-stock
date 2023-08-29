<?php

namespace App\Tests\Domain\Credit;

use App\Tests\FixtureTrait;
use App\Tests\KernelTestKase;
use App\Domain\Application\CancellableInterface;
use App\Domain\Credit\Gage\Entity\GageCredit;
use App\Domain\Credit\Service\GageCreditApprovalService;
use App\Domain\Credit\Service\GageCreditCreationService;
use App\Domain\Credit\Service\GageCreditRejectionService;
use App\Domain\Customer\Entity\Individual;
use App\Domain\Mounting\DTO\CreditRequirements;
use App\Domain\Mounting\Entity\CreditAgent;
use App\Domain\Mounting\Entity\CreditSupervisor;
use App\Domain\Mounting\FolderInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class GageCreditTest extends KernelTestKase
{
    use FixtureTrait;

    private Individual $individual;
    private CreditAgent $creditAgent;
    private FolderInterface $folder;
    private CreditSupervisor $supervisor;
    private CreditRequirements $requirements;
    
    public function setUp(): void
    {
        parent::setUp();
        [
            'credit_agent' => $this->creditAgent,
            'credit_supervisor' => $this->supervisor,
            'gage_folder' => $this->folder,
            'credit_requirement' => $this->requirements
        ] = $this->loadFixtures(['employee', 'credit_type', 'dto_credit', 'person', 'folder', 'attestation']);

        $this->creditAgent->setEvent(new EventDispatcher());
        $this->supervisor->setEvent(new EventDispatcher());
    }

    public function testGageCreditCreation()
    {
        $credit = $this->createCredit();

        $this->assertEquals($credit, $this->folder->getCredit());
        $this->assertEquals($credit->getCreditAgent(), $this->creditAgent);
        $this->assertEquals($credit->getCapital(), $this->requirements->capital);
    }

    public function testGageCreditApproval()
    {
        $service = new GageCreditApprovalService();
        $credit = $this->createCredit();
        $approval = $this->supervisor->approveCredit($service, $credit);

        $this->assertContains($approval, $credit->getApprovals());
        $this->assertEquals($approval->getApproving(), $this->supervisor);
    }

    public function testGageCreditRejecttion()
    {
        $service = new GageCreditRejectionService();
        $credit = $this->createCredit();
        $cause = "Ce credit est mal fait ! Veuillez changer la durée de cette crédit";
        $rejection = $this->supervisor->rejectCredit($service, $credit, $cause);

        $this->assertContains($rejection, $credit->getRejections());
        $this->assertEquals($rejection->getApproving(), $this->supervisor);
        $this->assertEquals($rejection->getCause(), $cause);
    }

    public function testGageCreditCancellation()
    {
        $credit = $this->createCredit();
        $cause = "Le client veut annuler son credit";
        /** @var CancellableInterface $creditCancelled */
        $creditCancelled = $this->supervisor->cancelCredit($credit, $cause);

        $this->assertNotNull($creditCancelled->getCancelledAt());
        $this->assertEquals($creditCancelled->getCancellationCause(), $cause);
        $this->assertEquals($credit->getCancelledBy(), $this->supervisor);
    }

    private function createCredit(): GageCredit
    {
        $service = new GageCreditCreationService($this->folder);
        return $this->creditAgent->createCredit($service, $this->requirements);
    }
}