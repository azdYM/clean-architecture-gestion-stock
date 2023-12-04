<?php

namespace App\Domain\Mounting;

use App\Domain\Credit\Entity\CreditType;
use App\Domain\Mounting\Entity\MountingSection;

trait TargetCreditTrait
{
    private function sectionTargetedCreditIsSectionGage(CreditType $targetCredit): bool
    {
        return $targetCredit->getMountingSection() instanceof MountingSection;
    }
}