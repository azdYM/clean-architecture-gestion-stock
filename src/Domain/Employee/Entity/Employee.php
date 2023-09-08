<?php

namespace App\Domain\Employee\Entity;

use App\Domain\Auth\User;
use App\Domain\Auth\UserRole;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Employee\CanAddRoleTrait;
use App\Domain\Employee\Exception\RoleAttributionException;
use App\Domain\Mounting\Entity\MountingSection;
use App\Domain\Garantee\Entity\EvaluationGageSection;
use App\Domain\Employee\Repository\EmployeeRepository;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee extends User
{
    use CanAddRoleTrait;

    #[ORM\Column(length: 180)]
    protected ?string $fullname = null;

    #[ORM\ManyToOne(targetEntity: EvaluationGageSection::class)]
    #[ORM\JoinColumn(name: 'evaluation_section_id', referencedColumnName: 'id')]
    private ?EvaluationGageSection $currentEvaluationSection = null;

    #[ORM\ManyToOne(targetEntity: MountingSection::class)]
    #[ORM\JoinColumn(name: 'mounting_section_id', referencedColumnName: 'id')]
    private ?MountingSection $currentMountingSection = null;

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;
        return $this;
    }

    public function getCurrentEvaluationSection(): ?EvaluationGageSection
    {
        return $this->currentEvaluationSection;
    }

    public function setCurrentEvaluationSection(?EvaluationGageSection $section): static
    {
        $this->currentEvaluationSection = $section;
        return $this;
    }

    public function getCurrentMountingSection(): ?MountingSection
    {
        return $this->currentMountingSection;
    }

    public function setCurrentMountingSection(?MountingSection $section): static
    {
        $this->currentMountingSection = $section;
        return $this;
    }

    public function setRoles(array $roles): static
    {
        parent::setRoles($roles);
        return $this;
    }

    public function addNewRole(UserRole $newRole): self|\Throwable
    {
        $currentRoles = $this->getRoles();
        try {
            $this->verifyCanAddRole($newRole, $currentRoles);
            $this->setRoles([$newRole->value, ...$currentRoles]);
        } catch (\Throwable $th) {
            throw new RoleAttributionException($th->getMessage());
        }

        return $this;
    }

    public function removeRole(UserRole $role) 
    {
        if ($this->hasRole($role, $this->getRoles())) {
            $this->setRoles(array_filter($this->getRoles(), fn($removed) => !$removed === $role->value));
        }
    }
}
