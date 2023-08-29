<?php

namespace App\Domain\Mounting;

use App\Domain\Employee\ROLE;
use App\Domain\Mounting\Entity\CreditAgent;
use App\Domain\Mounting\Entity\MountingSection;

trait WorkingCreditMountingSectionTrait
{
    public function setRoles(array $roles): static
    {
        if (CreditAgent::class === get_called_class()) {
            parent::setRoles([ROLE::AGENT]);
        } else
            parent::setRoles([ROLE::SUPERVISOR])
        ;

        return $this;
    }

    public function getMountingSection(): ?MountingSection
    {
        return $this->mountingSection;
    }

    public function setMountingSection(MountingSection $section): static
    {
        $this->mountingSection = $section;
        return $this;
    }
}

