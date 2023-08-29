<?php

namespace App\Tests\Domain\Employee\Repository;

use App\Tests\FixtureTrait;
use App\Domain\Employee\ROLE;
use App\Tests\RepositoryTestKase;
use App\Domain\Garantee\Entity\Evaluator;
use App\Domain\Garantee\Entity\Supervisor;
use App\Domain\Mounting\Entity\CreditAgent;
use App\Domain\Mounting\Entity\CreditSupervisor;
use App\Domain\Employee\Repository\EmployeeRepository;

class EmployeeRepositoryTest extends RepositoryTestKase
{
    use FixtureTrait;

    protected $repositoryEntity = EmployeeRepository::class;

    public function testEmployeeIsEvaluatorInSectionOr()
    {
        /**
         * @var Evaluator $evaluator
         */
        ['evaluator' => $evaluator] = $this->loadFixtures(['employee']);
        $this->assertEquals('azad_hassani@meck-moroni.org', $evaluator->getEmail());
        $this->assertContains(ROLE::AGENT, $evaluator->getRoles());
        $this->assertEquals('gold', $evaluator->getGageSection()->getEvaluationGageService()->getServiceName());
    }

    public function testEmployeeIsSupervisorInSectionOr()
    {
        /**
         * @var Supervisor $sealer
         */
        ['evaluation_supervisor' => $sealer] = $this->loadFixtures(['employee']);
        $this->assertEquals('imamou_mina@meck-moroni.org', $sealer->getEmail());
        $this->assertContains(ROLE::SUPERVISOR, $sealer->getRoles());
        $this->assertEquals('gold', $sealer->getGageSection()->getEvaluationGageService()->getServiceName());
    }

    public function testEmployeeIsCreditAgentInSectionGage()
    {
        /**
         * @var CreditAgent $agent
         */
        ['credit_agent' => $agent] = $this->loadFixtures(['employee']);

        $this->assertEquals('radjabou_saandi@meck-moroni.org', $agent->getEmail());
        $this->assertContains(ROLE::AGENT, $agent->getRoles());
        $this->assertEquals('gage', $agent->getMountingSection()->getMountingFolderService()->getServiceName());
    }

    public function testEmployeeIsSupervisorInSectionGage()
    {
        /**
         * @var CreditSupervisor $supervisor
         */
        ['credit_supervisor' => $supervisor] = $this->loadFixtures(['employee']);

        $this->assertEquals('abdoul_karim@meck-moroni.org', $supervisor->getEmail());
        $this->assertContains(ROLE::SUPERVISOR, $supervisor->getRoles());
        $this->assertEquals('gage', $supervisor->getMountingSection()->getMountingFolderService()->getServiceName());
    }
}