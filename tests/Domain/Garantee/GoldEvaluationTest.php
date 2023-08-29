<?php

namespace App\Tests\Domain\Garantee;

use App\Tests\FixtureTrait;
use App\Tests\KernelTestKase;
use App\Domain\Credit\CreditType;
use App\Domain\Customer\ClientInterface;
use App\Domain\Garantee\Entity\Evaluator;
use App\Domain\Garantee\Entity\Supervisor;
use App\Domain\Mounting\Entity\MountingSection;
use App\Domain\Application\CancellableInterface;
use App\Infrastrucutre\Evaluator\Item\GoldEvaluator;
use Symfony\Component\EventDispatcher\EventDispatcher;

class GoldEvaluationTest extends KernelTestKase
{
    use FixtureTrait;
    use CreationItemTrait;
    use EvaluationGaranteeTrait;

    private Evaluator $evaluator;
    private Supervisor $supervisor;
    private ClientInterface $individual;
    private GoldEvaluator $itemEvaluator;
    private MountingSection $mountingSection;
    private CreditType $creditType;

    public function setUp(): void
    {
        parent::setUp();
        [
            'individual1' => $this->individual,
            'evaluator' => $this->evaluator,
            'evaluation_supervisor' => $this->supervisor,
            'mounting_section' => $this->mountingSection,
            'credit_type' => $this->creditType,
        ] = $this->loadFixtures(['employee', 'credit_type', 'person']);
        
        $this->evaluator->setEvent(new EventDispatcher());
        $this->supervisor->setEvent(new EventDispatcher());
        $this->itemEvaluator = new GoldEvaluator;
    }

    public function testGaranteeIsEvaluated()
    {
        $priceGeneratedForEvaluation = 15000 + 12500 + 10000;
        $requirements = [
            ['name' => 'collier', 'quantity' => 4, 'carrat' => 22, 'weight' => 10],
            ['name' => 'Bague 1', 'quantity' => 3, 'carrat' => 20, 'weight' => 5],
            ['name' => 'Bague 2', 'quantity' => 2, 'carrat' => 16, 'weight' => 3]
        ];
        $attestation = $this->evaluate($requirements);
        
        $this->assertEquals($priceGeneratedForEvaluation, $attestation->getValorisation());
        $this->assertEquals(count($requirements), $attestation->getItems()->count());
    }

    public function testIfAttestationEvaluationIsGenerated()
    {
        $requirements = [['name' => 'Bague 2', 'quantity' => 2, 'carrat' => 16, 'weight' => 3]];
        $attestation = $this->evaluate($requirements);

        $this->assertEquals($this->individual, $attestation->getClient());
        $this->assertEquals($this->evaluator, $attestation->getEvaluator());
        $this->assertEquals($this->creditType, $attestation->getCreditTypeTargeted());
    }

    public function testIfAttestationIsApproved()
    {
        $requirements = [['name' => 'Bague 2', 'quantity' => 2, 'carrat' => 16, 'weight' => 3]];
        $attestation = $this->evaluate($requirements);
        $approval = $this->supervisor->approve($attestation, $this->mountingSection->getMountingFolderService());
        
        $this->assertEquals($approval->getApproving(), $this->supervisor);
        $this->assertEquals($approval->getAttestation(), $attestation);
    }

    public function testIfAttestationIsRejected()
    {
        $requirements = [['name' => 'Bague 2', 'quantity' => 2, 'carrat' => 16, 'weight' => 3]];
        $cause = "Le carrat que vous avez mis n'est pas supporté";
        $attestation = $this->evaluate($requirements);
        $rejection = $this->supervisor->reject($attestation, $cause);

        $this->assertEquals($rejection->getCause(), $cause);
        $this->assertEquals($rejection->getSupervisor(), $this->supervisor);
        $this->assertEquals($rejection->getAttestation(), $attestation);
    }

    public function testIfAttestationIsCanceled()
    {
        $requirements = [['name' => 'Bague 2', 'quantity' => 2, 'carrat' => 16, 'weight' => 3]];
        $cause = "Le carrat que vous avez mis n'est pas supporté";
        $attestation = $this->evaluate($requirements);
        /** @var CancellableInterface $cancellation */
        $cancellation = $this->supervisor->cancel($attestation, $cause);

        $this->assertNotNull($cancellation->getCancelledAt());
        $this->assertEquals($cancellation->getCancellationCause(), $cause);
        $this->assertEquals($cancellation->getCancelledBy(), $this->supervisor);
    }
}