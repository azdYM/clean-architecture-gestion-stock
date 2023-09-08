<?php

namespace App\Domain\Garantee\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Garantee\Entity\Evaluator;
use App\Domain\Garantee\Entity\Supervisor;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\Application\Entity\TimestampTrait;
use App\Domain\Application\Entity\IdentifiableTrait;
use App\Domain\Garantee\Entity\EvaluationGageService;
use App\Domain\Garantee\Repository\GageSectionRepository;

#[ORM\Entity(repositoryClass: GageSectionRepository::class)]
class EvaluationGageSection 
{
    use IdentifiableTrait;
    use TimestampTrait;

    #[ORM\OneToOne(targetEntity: EvaluationGageService::class, mappedBy: 'section')]
    private ?EvaluationGageService $evaluationGageService;
    
    #[ORM\JoinTable(name: 'agents_gage_sections')]
    #[ORM\JoinColumn(name: 'section_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'gage_evaluator_id', referencedColumnName: 'id', unique: true)]
    #[ORM\ManyToMany(targetEntity: Employee::class)]
    private Collection $evaluators;
    
    #[ORM\JoinTable(name: 'supervisors_gage_sections')]
    #[ORM\JoinColumn(name: 'section_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'gage_supervisor_id', referencedColumnName: 'id', unique: true)]
    #[ORM\ManyToMany(targetEntity: Employee::class)]
    private Collection $supervisors;

    public function __construct()
    {
        $this->evaluators = new ArrayCollection();
        $this->supervisors = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * @return Collection<int, Evaluator>
     */
    public function getEvaluators(): Collection
    {
        return $this->evaluators;
    }

    public function addEvaluators(Employee $evaluator): self
    {
        if (!$this->supervisors->contains($evaluator)) {
            $this->supervisors->add($evaluator);
        }

        return $this;
    }

    public function removeEvaluators(Employee $evaluator): self
    {
        if ($this->supervisors->contains($evaluator)) {
            $this->supervisors->removeElement($evaluator);
        }

        return $this;
    }

    /**
     * @return Collection<int, Supervisor>
     */
    public function getSupervisors(): Collection
    {
        return $this->supervisors;
    }

    public function addSupervisor(Employee $supervisor): self
    {
        if (!$this->supervisors->contains($supervisor)) {
            $this->supervisors->add($supervisor);
        }

        return $this;
    }

    public function removeSupervisor(Employee $supervisor): self
    {
        if ($this->supervisors->contains($supervisor)) {
            $this->supervisors->removeElement($supervisor);
        }

        return $this;
    }

    public function getEvaluationGageService(): ?EvaluationGageService
    {
        return $this->evaluationGageService;
    }

    public function setEvaluationGageService(EvaluationGageService $service): self
    {
        $this->evaluationGageService = $service;
        return $this;
    }
}