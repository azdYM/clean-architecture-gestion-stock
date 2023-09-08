<?php

namespace App\Infrastructure\DataFixtures;

use App\Domain\Auth\UserRole;
use App\Domain\Employee\Entity\Employee;

class EmployeeFactory extends UserFactory
{
    public static function create(?UserRole $role = null, ?array $infos = []): Employee 
    {
        self::$user = (new Employee)
            ->addNewRole($role)
        ;

        self::setDefaultUserInformations($infos);
        self::$user->setFullname($infos['fullname'] ?? 'Azad Hassani');
        return self::$user;
    }
}