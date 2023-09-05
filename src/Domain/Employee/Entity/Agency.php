<?php

namespace App\Domain\Employee\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Employee\Entity\Employee;
use Doctrine\Common\Collections\Collection;
use App\Domain\Employee\Entity\AgencyManager;
use App\Domain\Application\Entity\TimestampTrait;
use App\Domain\Application\Entity\IdentifiableTrait;
use App\Domain\Employee\Repository\AgencyRepository;
use App\Domain\Garantee\Entity\EvaluationGageService;
use App\Domain\Mounting\Entity\MountingCreditFolderService;

#[ORM\Entity(repositoryClass: AgencyRepository::class)]
class Agency
{
    use IdentifiableTrait;
    use TimestampTrait;

    #[ORM\Column(length: 100)]
    private ?string $label = null;

    #[ORM\OneToMany(targetEntity: EvaluationGageService::class, mappedBy: 'agency')]
    private Collection $evaluationGageServices;

    #[ORM\OneToMany(targetEntity: MountingCreditFolderService::class, mappedBy: 'agency')]
    private Collection $mountingCreditFolderServices;

    #[ORM\OneToOne(targetEntity: Employee::class, inversedBy: 'agency')]
    #[ORM\JoinColumn(name: 'manager_id', referencedColumnName: 'id')]
    private ?AgencyManager $manager = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function getManager(): AgencyManager
    {
        return $this->manager;
    }

    public function setManager(AgencyManager $manager): self
    {
        $this->manager = $manager;
        return $this;
    }

    /**
     * @return Collection<int, EvaluationGageService>
     */
    public function getEvaluationGageServices(): Collection
    {
        return $this->evaluationGageServices;
    }

    public function addEvaluationGageService(EvaluationGageService $service): self
    {
        if (!$this->evaluationGageServices->contains($service)) {
            $this->evaluationGageServices->add($service);
        }

        return $this;
    }

    public function removeEvaluationGageService(EvaluationGageService $service): self
    {
        if ($this->evaluationGageServices->contains($service)) {
            $this->evaluationGageServices->removeElement($service);
        }

        return $this;
    }
}