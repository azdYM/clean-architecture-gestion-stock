<?php

namespace App\Domain\Garantee;

use App\Domain\Employee\Entity\Employee;

trait EvaluationTrait
{
    public function getEvaluator(): Employee
    {
        return $this->evaluator;
    }

    public function setEvaluator(Employee $evaluator): static
    {
        $this->evaluator = $evaluator;
        return $this;
    }

    public function getEvaluatorDescription(): ?string
    {
        return $this->evaluatorDescription;
    }

    public function setEvaluatorDescription(?string $description): static
    {
        $this->evaluatorDescription = $description;
        return $this;
    }
}