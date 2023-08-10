<?php

namespace App\Domain\Garantee;

use Doctrine\Common\Collections\Collection;
use App\Domain\Garantee\EvaluationInterface;

interface EvaluatedInterface
{
    /**
     * @return Collection<int, EvaluationInterface>
     */
    public function getEvaluations(): Collection;
    public function addEvaluation(EvaluationInterface $evaluation): static;
}