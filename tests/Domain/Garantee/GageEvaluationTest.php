<?php

namespace App\Tests\Domain\Garantee;

use App\Tests\FixtureTrait;
use App\Tests\KernelTestKase;
use App\Domain\Credit\Entity\CreditType;
use App\Domain\Customer\ClientInterface;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Garantee\Entity\EvaluationGageSection;

class GageEvaluationTest extends KernelTestKase
{
    use FixtureTrait;
    use CreationItemTrait;
    use EvaluationGaranteeTrait;

    private Employee $evaluator;
    private ClientInterface $individual;
    private CreditType $creditType;
    private EvaluationGageSection $gageSection;

    public function setUp(): void
    {
        parent::setUp();
        [
            'individual1' => $this->individual,
            'evaluator' => $this->evaluator,
            'credit_type' => $this->creditType,
            'evaluation_gage_section' => $this->gageSection
        ] = $this->loadFixtures(['employee', 'credit_type', 'person']);
    }

    public function testGaranteeIsEvaluated()
    {
        $priceGeneratedForEvaluation = 15000 + 12500 + 10000;
        $requirements = [
            ['name' => 'collier', 'quantity' => 4, 'carrat' => 22, 'weight' => 10],
            ['name' => 'Bague 1', 'quantity' => 3, 'carrat' => 20, 'weight' => 5],
            ['name' => 'Bague 2', 'quantity' => 2, 'carrat' => 16, 'weight' => 3]
        ];
        $attestation = $this->evaluate($requirements, $this->evaluator);
        
        $this->assertEquals($priceGeneratedForEvaluation, $attestation->getValorisation());
        $this->assertEquals(count($requirements), $attestation->getItems()->count());
    }

    public function testIfAttestationEvaluationIsGenerated()
    {
        $requirements = [['name' => 'Bague 2', 'quantity' => 2, 'carrat' => 16, 'weight' => 3]];
        $attestation = $this->evaluate($requirements, $this->evaluator);
        
        $this->assertEquals($this->individual, $attestation->getClient());
        $this->assertEquals($this->evaluator, $attestation->getEvaluator());
        $this->assertEquals($this->creditType, $attestation->getCreditTypeTargeted());
    }
}