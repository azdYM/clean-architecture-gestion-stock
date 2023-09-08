<?php

namespace App\Tests\Domain\Credit;

use App\Tests\FixtureTrait;
use App\Tests\KernelTestKase;
use App\Domain\Customer\Entity\Individual;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Employee\Service\CreditMountingService;
use App\Domain\Garantee\Entity\AttestationApproval;
use App\Domain\Mounting\DTO\CreditRequirements;
use App\Domain\Mounting\FolderInterface;

class CreditGageMountingTest extends KernelTestKase
{
    use FixtureTrait;
    use CreationCreditTrait;

    private Individual $individual;
    private Employee $creditAgent;
    private FolderInterface $folder;
    private Employee $supervisor;
    private CreditRequirements $requirements;
    private CreditMountingService $service;
    private AttestationApproval $attestationApproval;
    
    public function setUp(): void
    {
        parent::setUp();
        [
            'credit_agent' => $this->creditAgent,
            'credit_supervisor' => $this->supervisor,
            'gage_folder' => $this->folder,
            'credit_requirement' => $this->requirements,
            'attestation_approval' => $this->attestationApproval
        ] = $this->loadFixtures(['employee', 'credit_type', 'dto_credit', 'person', 'folder', 'attestation']);
    }

    public function testGageCreditCreation()
    {
        $credit = $this->createGageCredit();

        $this->assertEquals($credit, $this->folder->getCredit());
        $this->assertEquals($credit->getCreditAgent(), $this->creditAgent);
        $this->assertEquals($credit->getCapital(), $this->requirements->capital);
    }
}