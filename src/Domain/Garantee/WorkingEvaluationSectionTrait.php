<?php

namespace App\Domain\Garantee;

use App\Domain\Employee\ROLE;
use App\Domain\Garantee\Entity\Evaluator;
use App\Domain\Garantee\Entity\GageSection;

trait WorkingEvaluationSectionTrait
{
    public function setRoles(array $roles): static
    {
        if (Evaluator::class === get_called_class()) {
            parent::setRoles([ROLE::AGENT]);
        } else
            parent::setRoles([ROLE::SUPERVISOR])
        ;

        return $this;
    }

    public function getGageSection(): ?GageSection
    {
        return $this->gageSection;
    }

    public function setGageSection(GageSection $section): static
    {
        $this->gageSection = $section;
        return $this;
    }
}