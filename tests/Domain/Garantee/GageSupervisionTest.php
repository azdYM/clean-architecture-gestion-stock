<?php

namespace App\Tests\Domain\Garantee;

use App\Tests\FixtureTrait;
use App\Tests\KernelTestKase;

use App\Domain\Credit\Entity\CreditType;
use App\Domain\Customer\ClientInterface;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Mounting\Entity\MountingSection;
use App\Domain\Application\CancellableInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use App\Domain\Employee\Service\GageSupervisionService;

class GageSupervisionTest extends KernelTestKase
{
    use FixtureTrait;
    use CreationItemTrait;
    use EvaluationGaranteeTrait;

    private Employee $supervisor;
    private Employee $evaluator;
    private GageSupervisionService $service;
    private MountingSection $mountingSection;
    private ClientInterface $individual;
    private CreditType $creditType;

    public function setUp(): void
    {
        parent::setUp();
        [
            'individual1' => $this->individual,
            'evaluation_supervisor' => $this->supervisor,
            'credit_type' => $this->creditType,
            'evaluator' => $this->evaluator,
            'mounting_section' => $this->mountingSection,
        ] = $this->loadFixtures(['employee', 'credit_type', 'person']);
        $this->service = new GageSupervisionService($this->supervisor, new EventDispatcher);
    }

    public function testIfAttestationIsApproved()
    {
        $requirements = [['name' => 'Bague 2', 'quantity' => 2, 'carrat' => 16, 'weight' => 3]];
        $attestation = $this->evaluate($requirements, $this->evaluator);
        $approval = $this->service->approve($attestation, $this->mountingSection->getMountingFolderService());
        
        $this->assertEquals($approval->getApproving(), $this->supervisor);
        $this->assertEquals($approval->getAttestation(), $attestation);
    }

    public function testIfAttestationIsRejected()
    {
        $requirements = [['name' => 'Bague 2', 'quantity' => 2, 'carrat' => 16, 'weight' => 3]];
        $cause = "Le carrat que vous avez mis n'est pas supporté";
        $attestation = $this->evaluate($requirements, $this->evaluator);
        $rejection = $this->service->reject($attestation, $cause);

        $this->assertEquals($rejection->getCause(), $cause);
        $this->assertEquals($rejection->getSupervisor(), $this->supervisor);
        $this->assertEquals($rejection->getAttestation(), $attestation);
    }

    public function testIfAttestationIsCanceled()
    {
        $requirements = [['name' => 'Bague 2', 'quantity' => 2, 'carrat' => 16, 'weight' => 3]];
        $cause = "Le carrat que vous avez mis n'est pas supporté";
        $attestation = $this->evaluate($requirements, $this->evaluator);
        /** @var CancellableInterface $cancellation */
        $cancellation = $this->service->cancel($attestation, $cause);

        $this->assertNotNull($cancellation->getCancelledAt());
        $this->assertEquals($cancellation->getCancellationCause(), $cause);
        $this->assertEquals($cancellation->getCancelledBy(), $this->supervisor);
    }
}



