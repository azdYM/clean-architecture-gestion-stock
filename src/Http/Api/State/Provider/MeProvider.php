<?php

namespace App\Http\Api\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Domain\Employee\Entity\Employee;
use App\Http\Api\DTO\User\Employee as DTOEmployee;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class MeProvider implements ProviderInterface
{
    public function __construct
    (
        private EntityManagerInterface $em,
        private Security $security,
    ){}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $user = $this->security->getUser();
        return $this->mapEntityToDto($user);
    }

    private function mapEntityToDto(Employee $employee): DTOEmployee
    {
        $dtoEmployee = new DTOEmployee();

        ['agency' => $agency, 'service' => $service] = $this->getAgencyAndService($employee);
        
        $dtoEmployee->id = $employee->getId();
        $dtoEmployee->email = $employee->getEmail();
        $dtoEmployee->username = $employee->getUsername();
        $dtoEmployee->fullname = $employee->getFullname();
        $dtoEmployee->roles = $employee->getRoles();

        $dtoEmployee->workingService = $service;

        return $dtoEmployee;
    }

    /**
     *
     * @param Employee $employee
     */
    private function getAgencyAndService(Employee $employee): array 
    {
        if ($employee->getCurrentEvaluationSection() !== null) {
            // $service = $employee
            //     ->getCurrentEvaluationSection()
            //     ->getEvaluationGageService()
            // ;
            
            return [
                'agency' => null, 
                'service' => 'Evaluation gage'
            ];
        }

        else if ($employee->getCurrentMountingSection() !== null) {
            // $service = $employee
            //     ->getCurrentMountingSection()
            //     ->getMountingFolderService()
            // ;

            return [
                'agency' => null, 
                'service' => 'Montage de crédit'
            ];
        }

        else {

        }
    }
}