<?php

namespace App\Domain\Mounting;

use App\Domain\Credit\CreditType;

trait TargetCreditTrait
{
    private function sectionTargetedCreditIsSectionGage(CreditType $targetCredit): bool
    {
        return $targetCredit->getMountingSection() instanceof Mounti;
    }
}