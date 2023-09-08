<?php

namespace App\Domain\Employee;

use App\Domain\Auth\UserRole;
use App\Domain\Employee\Exception\RoleAttributionException;

trait CanAddRoleTrait
{
    private const RoleSupportedByCreditAgent = [
        UserRole::CreditAgent->value,
        UserRole::Mixt->value
    ];

    private const RoleSupportedByCreditSupervisor = [
        UserRole::CreditSupervisor->value,
        UserRole::Mixt->value
    ];

    private const RoleSupportedByGageEvaluator = [
        UserRole::GageEvaluator->value,
        UserRole::Mixt->value
    ];

    private const RoleSupportedByMixt = [
        UserRole::GageEvaluator->value,
        UserRole::GageSupervisor->value,
        UserRole::CreditAgent->value,
        UserRole::AgencyManager->value,
        UserRole::CreditManager->value,
        UserRole::GageManager->value,
        UserRole::Mixt->value
    ];

    private const RoleSupportedByGageSupervisor = [
        UserRole::GageSupervisor->value,
        UserRole::Mixt->value
    ];

    private const RoleSupportedByAgencyManager = [
        UserRole::AgencyManager->value,
        UserRole::Mixt->value
    ];

    private const RoleSupportedByCreditManager = [
        UserRole::CreditManager->value,
        UserRole::Mixt->value
    ];

    private const RoleSupportedByGageManager = [
        UserRole::GageManager->value,
        UserRole::Mixt->value
    ];

    private function verifyCanAddRole(UserRole $role, array $currentRoles = []): bool|\Throwable
    {
        if ($this->hasRole($role, $currentRoles)) {
            throw new RoleAttributionException(sprintf("Le role %s existe déjà !", $role->label()));
        }

        if (!$this->canAddRoleInCurrentRoles($role, $currentRoles)) {
            throw new RoleAttributionException(
                sprintf("Il est impossible d'ajouter le role %s :) car il est incompatible avec un des rôles existant", $role->label())
            );
        }
    
        return true;
    }

    private function hasRole(UserRole $role, array $roles): bool
    {
        return in_array($role->value, $roles);
    }

    private function canAddRoleInCurrentRoles(UserRole $roleAdded, array $currentRoles): bool
    {
        if (count($currentRoles) === 0) {
            return true;
        }

        foreach($currentRoles as $role) {
            $rolesSupported = $this->getRolesSupported($role);
            if ($this->hasRole($roleAdded, $rolesSupported)) {
                return true;
            }
        }

        return false;
    }

    private function getRolesSupported(string $role): array
    {
        return match (true) {
            $role === UserRole::GageEvaluator->value    => self::RoleSupportedByGageEvaluator,
            $role === UserRole::GageSupervisor->value   => self::RoleSupportedByGageSupervisor,
            $role === UserRole::CreditAgent->value      => self::RoleSupportedByCreditAgent,
            $role === UserRole::CreditSupervisor->value => self::RoleSupportedByCreditSupervisor,
            $role === UserRole::CreditManager->value    => self::RoleSupportedByCreditManager,
            $role === UserRole::GageManager->value      => self::RoleSupportedByGageManager,
            $role === UserRole::AgencyManager->value    => self::RoleSupportedByAgencyManager,
            $role === UserRole::Mixt->value             => self::RoleSupportedByMixt,
            default => throw new RoleAttributionException(sprintf("le role %s n'est pas supporté", $role))
        };
    }
}