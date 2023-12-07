<?php

namespace App\Tests\Domain\Mounting;

use App\Tests\FixtureTrait;
use App\Tests\KernelTestKase;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Customer\Entity\Individual;
use App\Domain\Mounting\DTO\FolderRequirements;
use App\Tests\Domain\Garantee\CreationItemTrait;
use App\Domain\Garantee\Entity\AttestationApproval;
use App\Domain\Mounting\Entity\ShortTerm\GageFolder;
use App\Domain\Employee\Service\CreditMountingService;
use App\Tests\Domain\Garantee\EvaluationGaranteeTrait;
use Symfony\Component\EventDispatcher\EventDispatcher;
use App\Domain\Mounting\Service\GageFolderMountingService;

class FolderMountingTest extends KernelTestKase
{
    use FixtureTrait;
    use CreationItemTrait;
    use EvaluationGaranteeTrait;

    private Individual $individual;
    private Employee $creditAgent;
    private AttestationApproval $attestationApproval;

    public function setUp(): void
    {
        parent::setUp();
        [
            'credit_agent' => $this->creditAgent,
            'attestation_approval' => $this->attestationApproval,
        ] = $this->loadFixtures(['employee', 'credit_type', 'person', 'attestation']);
    }

    public function testFolderCreditIsMounted()
    {
        $attestation = $this->attestationApproval->getAttestation();
        $folderRequirements = (new FolderRequirements)
            ->setClient($attestation->getClient())
            ->addAttestation($attestation)
        ;

        $service = new CreditMountingService($this->creditAgent, new EventDispatcher);
        $folder = $service->mountFolder(new GageFolderMountingService, $folderRequirements);

        $this->assertInstanceOf(GageFolder::class, $folder);
        $this->assertContains($folder, $attestation->getClient()->getPortfolio()->getCreditFolders());
    }
}