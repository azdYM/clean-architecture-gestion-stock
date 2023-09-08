<?php

namespace App\Tests\Domain\Employee\Repository;

use App\Domain\Auth\UserRole;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Employee\Exception\RoleAttributionException;
use App\Tests\FixtureTrait;
use App\Tests\RepositoryTestKase;
use App\Domain\Employee\Repository\EmployeeRepository;

class UserRoleTest extends RepositoryTestKase
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
        ['evaluator' => $this->evaluator] = $this->loadFixtures(['employee']);

    }

    public function testAddNewRole()
    {
        $evaluator = $this->createEmployee(UserRole::GageEvaluator);
        $evaluator->addNewRole(UserRole::Mixt);
        $creditSupervisor = $this->createEmployee(UserRole::CreditSupervisor);
        
        $this->assertContains(UserRole::GageEvaluator->value, $evaluator->getRoles());
        $this->assertCount(2, $evaluator->getRoles());
        $this->assertContains(UserRole::CreditSupervisor->value, $creditSupervisor->getRoles());
    }

    public function testIncompatibilityBetwenSeveralDifferentRoles()
    {
        $role = UserRole::GageSupervisor;

        $this->expectException(RoleAttributionException::class);
        $this->expectExceptionMessage(
            sprintf(
                "Il est impossible d'ajouter le role %s :) car il est incompatible avec un des rôles existant", 
                $role->label()
            )
        );

       $this->evaluator->addNewRole($role);
    }

    public function testAlreadyExistRole()
    {
        $role = UserRole::GageEvaluator;

        $this->expectException(RoleAttributionException::class);
        $this->expectExceptionMessage(sprintf("Le role %s existe déjà !", $role->label()));
        $this->evaluator->addNewRole($role);
    }

    public function testRemoveRole()
    {
        $this->evaluator->addNewRole(UserRole::Mixt);
        $this->evaluator->removeRole(UserRole::Mixt);

        $this->assertNotContains(UserRole::Mixt->value, $this->evaluator->getRoles());
    }   

    private function createEmployee(UserRole $role): Employee
    {
        return (new Employee)
            ->addNewRole($role)
        ;
    }
}