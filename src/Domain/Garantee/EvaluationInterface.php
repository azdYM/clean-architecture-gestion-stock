<?php

namespace App\Domain\Garantee;

use App\Domain\Employee\Entity\Employee;

interface EvaluationInterface
{
    public function getEvaluatedAt(): ?\DateTimeInterface;
    public function setEvaluator(Employee $evaluator): self;
    public function getEvaluator(): ?Employee;
    public function setDescriptionEvaluator(?string $description): self;
    public function getDescriptionEvaluator(): ?string;
    public function setGaranteeEvaluated(GaranteeInterface $garantee): self;
    public function getGaranteeEvaluated(): ?GaranteeInterface;
    public function setSealer(Employee $sealer): self;
    public function getSealer(): ?Employee;
    public function setDescriptionSealer(?string $description): self;
    public function getDescriptionSealer(): ?string;
    public function setSealed(bool $sealed): self;
    public function setSealedAt(\DateTimeInterface $sealedAt): self;
}