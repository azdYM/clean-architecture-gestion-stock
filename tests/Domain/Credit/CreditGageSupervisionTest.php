<?php

namespace App\Tests\Domain\Credit;

use App\Tests\FixtureTrait;
use App\Tests\KernelTestKase;
use App\Domain\Application\CancellableInterface;
use App\Domain\Credit\Service\GageCreditApprovalService;
use App\Domain\Credit\Service\GageCreditRejectionService;
use App\Domain\Customer\Entity\Individual;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Employee\Service\CreditSupervisionService;
use App\Domain\Mounting\DTO\CreditRequirements;
use App\Domain\Mounting\FolderInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class CreditGageSupervisionTest extends KernelTestKase
{
    use FixtureTrait;
    use CreationCreditTrait;

    private Individual $individual;
    private Employee $creditAgent;
    private FolderInterface $folder;
    private Employee $supervisor;
    private CreditRequirements $requirements;
    private CreditSupervisionService $service;
    
    public function setUp(): void
    {
        parent::setUp();
        [
            'credit_agent' => $this->creditAgent,
            'credit_supervisor' => $this->supervisor,
            'gage_folder' => $this->folder,
            'credit_requirement' => $this->requirements
        ] = $this->loadFixtures(['employee', 'credit_type', 'dto_credit', 'person', 'folder', 'attestation']);

        $this->service = new CreditSupervisionService($this->supervisor, new EventDispatcher);
    }

    public function testGageCreditApproval()
    {
        $service = new GageCreditApprovalService();
        $credit = $this->createGageCredit();
        $approval = $this->service->approveCredit($service, $credit);

        $this->assertContains($approval, $credit->getApprovals());
        $this->assertEquals($approval->getApproving(), $this->supervisor);
    }

    public function testGageCreditRejecttion()
    {
        $service = new GageCreditRejectionService();
        $credit = $this->createGageCredit();
        $cause = "Ce credit est mal fait ! Veuillez changer la durée de cette crédit";
        $rejection = $this->service->rejectCredit($service, $credit, $cause);

        $this->assertContains($rejection, $credit->getRejections());
        $this->assertEquals($rejection->getApproving(), $this->supervisor);
        $this->assertEquals($rejection->getCause(), $cause);
    }

    public function testGageCreditCancellation()
    {
        $credit = $this->createGageCredit();
        $cause = "Le client veut annuler son credit";
        /** @var CancellableInterface $creditCancelled */
        $creditCancelled = $this->service->cancelCredit($credit, $cause);

        $this->assertNotNull($creditCancelled->getCancelledAt());
        $this->assertEquals($creditCancelled->getCancellationCause(), $cause);
        $this->assertEquals($credit->getCancelledBy(), $this->supervisor);
    }
}