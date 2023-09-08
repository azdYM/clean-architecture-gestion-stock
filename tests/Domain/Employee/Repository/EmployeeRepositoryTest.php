<?php

namespace App\Tests\Domain\Employee\Repository;

use App\Domain\Auth\UserRole;
use App\Domain\Employee\Entity\Employee;
use App\Tests\FixtureTrait;
use App\Tests\RepositoryTestKase;
use App\Domain\Employee\Repository\EmployeeRepository;

class EmployeeRepositoryTest extends RepositoryTestKase
{
    use FixtureTrait;

    protected $repositoryEntity = EmployeeRepository::class;
    private Employee $evaluator;
    private Employee $sealer;
    private Employee $agent;
    private Employee $creditSupervisor;

    public function setUp(): void
    {
        parent::setUp();
        
        [
            'evaluator' => $this->evaluator,
            'evaluation_supervisor' => $this->sealer,
            'credit_agent' => $this->agent,
            'credit_supervisor' => $this->creditSupervisor
        ] = $this->loadFixtures(['employee']);

    }

    public function testEmployeeIsEvaluatorInSectionOr()
    {
        $this->em->persist($this->evaluator);
        $this->em->flush();
        $this->assertEquals('azad_hassani@meck-moroni.org', $this->evaluator->getEmail());
        $this->assertContains(UserRole::GageEvaluator->value, $this->evaluator->getRoles());
        $this->assertEquals('gold', $this->evaluator
            ->getCurrentEvaluationSection()->getEvaluationGageService()->getServiceName()
        );
    }

    public function testEmployeeIsSupervisorInSectionOr()
    {
        $this->assertEquals('imamou_mina@meck-moroni.org', $this->sealer->getEmail());
        $this->assertContains(UserRole::GageSupervisor->value, $this->sealer->getRoles());
        $this->assertEquals('gold', $this->sealer
            ->getCurrentEvaluationSection()->getEvaluationGageService()->getServiceName()
        );
    }

    public function testEmployeeIsCreditAgentInSectionGage()
    {
        $this->assertEquals('radjabou_saandi@meck-moroni.org', $this->agent->getEmail());
        $this->assertContains(UserRole::CreditAgent->value, $this->agent->getRoles());
        $this->assertEquals('gage', $this->agent
            ->getCurrentMountingSection()->getMountingFolderService()->getServiceName()
        );
    }

    public function testEmployeeIsSupervisorInSectionGage()
    {
        $this->assertEquals('abdoul_karim@meck-moroni.org', $this->creditSupervisor->getEmail());
        $this->assertContains(UserRole::CreditSupervisor->value, $this->creditSupervisor->getRoles());
        $this->assertEquals('gage', $this->creditSupervisor
            ->getCurrentMountingSection()->getMountingFolderService()->getServiceName()
        );
    }
}