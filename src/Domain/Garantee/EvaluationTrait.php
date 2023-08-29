<?php

namespace App\Domain\Garantee;

trait EvaluationTrait
{
    public function getEvaluator(): EvaluatorInterface
    {
        return $this->evaluator;
    }

    public function setEvaluator(EvaluatorInterface $evaluator): static
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