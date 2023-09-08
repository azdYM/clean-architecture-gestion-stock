<?php

namespace App\Domain\Auth;

enum UserRole: string 
{
    case CreditManager    = 'ROLE_CREDIT_MANAGER';
    case GageManager      = 'ROLE_GAGE_MANAGER';
    case AgencyManager    = 'ROLE_AGENCY_MANAGER';
    case GageEvaluator    = 'ROLE_GAGE_EVALUATOR';
    case GageSupervisor   = 'ROLE_GAGE_SUPERVISOR';
    case CreditAgent      = 'ROLE_CREDIT_AGENT';
    case CreditSupervisor = 'ROLE_CREDIT_SUPERVISOR';
    case Mixt             = 'ROLE_MIXT';

    public function label(): string
    {
        return match ($this) {
            static::CreditSupervisor => 'Chef d\'agence',
            static::CreditManager   => 'Chef de crédits',
            static::GageManager     => 'Chef de gages',
            static::AgencyManager   => 'Chef d\'agence',
            static::GageEvaluator   => 'Evaluateur de gage',
            static::GageSupervisor  => 'Superviseur de l\'valuation de gage',
            static::CreditAgent     => 'Agent de crédit',
            static::Mixt            => 'Dev'
        };
    }
}