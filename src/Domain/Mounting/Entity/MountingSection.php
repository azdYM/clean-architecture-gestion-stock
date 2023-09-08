<?php

namespace App\Domain\Mounting\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Mounting\Entity\Supervisor;
use Doctrine\Common\Collections\Collection;
use App\Domain\Application\Entity\IdentifiableTrait;
use App\Domain\Mounting\Entity\MountingCreditFolderService;
use App\Domain\Mounting\Repository\MountingSectionRepository;

#[ORM\Entity(repositoryClass: MountingSectionRepository::class)]
class MountingSection 
{
    use IdentifiableTrait;

    #[ORM\JoinTable(name: 'agents_mounting_sections')]
    #[ORM\JoinColumn(name: 'section_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'credit_agent_id', referencedColumnName: 'id', unique: true)]
    #[ORM\ManyToMany(targetEntity: Employee::class, cascade: ['persist'])]
    private Collection $creditAgents;

    #[ORM\JoinTable(name: 'supervisors_mounting_sections')]
    #[ORM\JoinColumn(name: 'section_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'credit_supervisor_id', referencedColumnName: 'id', unique: true)]
    #[ORM\ManyToMany(targetEntity: Employee::class, cascade: ['persist'])]
    private Collection $supervisors;

    #[ORM\OneToOne(targetEntity: MountingCreditFolderService::class, mappedBy: 'section')]
    private ?MountingCreditFolderService $mountingFolderService = null;

    /**
     * @return Collection<int, Employee>
     */
    public function getCreditAgents(): Collection
    {
        return $this->creditAgents;
    }

    public function addCreditAgent(Employee $agent): self
    {
        if (!$this->creditAgents->contains($agent)) {
            $this->creditAgents->add($agent);
        }

        return $this;
    }

    public function removeCreditAgent(Employee $agent): self
    {
        if ($this->creditAgents->contains($agent)) {
            $this->creditAgents->removeElement($agent);
        }

        return $this;
    }

    /**
     * @return Collection<int, Supervisor>
     */
    public function getSupervisors()
    {
        return $this->supervisors;
    }

    public function addSupervisor(Employee $supervisor)
    {
        if (!$this->supervisors->contains($supervisor)) {
            $this->supervisors->add($supervisor);
        }

        return $this;
    }

    public function removeSupervisor(Employee $supervisor)
    {
        if ($this->supervisors->contains($supervisor)) {
            $this->supervisors->removeElement($supervisor);
        }

        return $this;
    }

    public function getMountingFolderService(): MountingCreditFolderService
    {
        return $this->mountingFolderService;
    }

    public function setMountingFolderService(MountingCreditFolderService $service): self
    {
        $this->mountingFolderService = $service;
        return $this;
    }
}