<?php

namespace App\Infrastructure\DataFixtures\Employee;

use App\Domain\Auth\UserRole;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Infrastructure\DataFixtures\Employee\CreationTrait;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EmployeeFixtures extends Fixture
{
    use CreationTrait;

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {}

    public function load(ObjectManager $manager): void
    {
        $agencyManager = $this->createEmployee(
            fullname: "Abdoul-wahid", 
            username: 'abdoul_wahid', 
            email: 'abdoul-wahid@meck-moroni.org',
            password: 'mina',
            role: UserRole::AgencyManager
        );

        $agency = $this->createAgency($agencyManager, 'Base Meck-Moroni');
        $gageService = $this->createGageService($agency, 'Or');
        $mountingFolderService = $this->createMountingService($agency, 'Gage');
        $gageSection = $this->createGageSection($gageService);
        $mountingSection = $this->createMountingSection($mountingFolderService);

        $gageService->setSection($gageSection);
        $mountingFolderService->setSection($mountingSection);

        $evaluator = $this->createEmployee(
            fullname: "Issa Mohame",
            username: 'issa',
            email: 'issa_mohamed@meck-moroni.org',
            password: 'mina',
            role: UserRole::GageEvaluator,
            gageSection: $gageSection
        );

        $supervisor = $this->createEmployee(
            fullname: "Abdoul-karim Ibrahim", 
            username: 'abdoul-karim', 
            email: 'abdoul-karim_ibrahim@meck-moroni.org',
            password: 'mina',
            role: UserRole::GageSupervisor,
            gageSection: $gageSection
        );

        $creditAgent = $this->createEmployee(
            fullname: "Imamou Mina", 
            username: 'mina', 
            email: 'imamou_mina@meck-moroni.org',
            password: 'mina',
            role: UserRole::CreditAgent,
            mountingSection: $mountingSection
        );

        $creditSupervisor = $this->createEmployee(
            fullname: "Radjaou Sandi", 
            username: 'radjabou', 
            email: 'radjabou_sandi@meck-moroni.org',
            password: 'mina',
            role: UserRole::CreditSupervisor,
            mountingSection: $mountingSection
        );

        $manager->persist($agencyManager);
        $manager->persist($agency);
        $manager->persist($evaluator);
        $manager->persist($gageService);
        $manager->persist($mountingFolderService);
        $manager->persist($gageSection);
        $manager->persist($mountingSection);
        $manager->persist($supervisor);
        $manager->persist($creditAgent);
        $manager->persist($creditSupervisor);

        $manager->flush();
    }
}
