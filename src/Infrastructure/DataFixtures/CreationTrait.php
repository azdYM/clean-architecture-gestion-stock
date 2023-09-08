<?php

namespace App\Infrastructure\DataFixtures;

use App\Domain\Auth\UserRole;
use App\Domain\Employee\Entity\Agency;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Garantee\Entity\EvaluationGageSection;
use App\Domain\Garantee\Entity\EvaluationGageService;
use App\Domain\Mounting\Entity\MountingCreditFolderService;
use App\Domain\Mounting\Entity\MountingSection;

trait CreationTrait
{
    public function createEmployee(
        string $fullname, 
        string $username, 
        string $email, 
        ?string $password = null, 
        UserRole $role,
        ?MountingSection $mountingSection = null,
        ?EvaluationGageSection $gageSection = null
    ): Employee
    {
        $employee = EmployeeFactory::create(
            $role,
            [
                'username' => $username,
                'email' => $email,
                'fullname' => $fullname
            ]
        );

        $employee
            ->setPassword($this->passwordHasher->hashPassword($employee, $password ?? 'mina'))
            ->setCurrentMountingSection($mountingSection)
            ->setCurrentEvaluationSection($gageSection)
        ;

        return $employee;
    }

    public function createAgency(Employee $agencyManager, string $label)
    {
        return (new Agency)
            ->setManager($agencyManager)
            ->setLabel($label)
        ;
    }

    public function createGageService(Agency $agency, string $serviceName)
    {
        return (new EvaluationGageService)
            ->setAgency($agency)
            ->setServiceName($serviceName)
        ;
    }

    public function createMountingService(Agency $agency, string $serviceName)
    {
        return (new MountingCreditFolderService)
            ->setAgency($agency)
            ->setServiceName($serviceName)
        ;
    }

    public function createGageSection(EvaluationGageService $service)
    {
        return (new EvaluationGageSection)
            ->setEvaluationGageService($service)
        ;
    }

    public function createMountingSection(MountingCreditFolderService $service)
    {
        return (new MountingSection)
            ->setMountingFolderService($service)
        ;
    }
}