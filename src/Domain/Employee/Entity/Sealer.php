<?php

namespace App\Domain\Employee\Entity;

use App\Domain\Employee\ROLE;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Garantee\Entity\Evaluation;
use Doctrine\Common\Collections\Collection;
use App\Domain\Garantee\EvaluationInterface;
use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\Sealer\Repository\SealerRepository;

#[ORM\Entity(repositoryClass: SealerRepository::class)]
class Sealer extends Employee
{
    /**
     * @var Collection<int, EvaluationInterface>
     */
    #[ORM\OneToMany(targetEntity: Evaluation::class, mappedBy: 'sealer', cascade: ['persist'])]
    protected Collection $supervisions;

    public function __construct()
    {
        parent::__construct();
        $this->supervisions = new ArrayCollection();
    }
    
    public function setRoles(array $roles): static
    {
        parent::setRoles([ROLE::SEALER]);
        return $this;
    }

    public function supervise(EvaluationInterface $evaluation, ?string $description): self
    {
        $evaluation
            ->setSealer($this)
            ->setDescriptionSealer($description)
            ->setSealed(true)
            ->setSealedAt(new \DateTimeImmutable())
        ;

        $this->addSupervision($evaluation);
        return $this;
    }

    /**
     * @return Collection<int, EvaluationInterface>
     */
    public function getSupervisions(): Collection
    {
        return $this->supervisions;
    }

    private function addSupervision(EvaluationInterface $evaluation): self
    {
        if (!$this->supervisions->contains($evaluation)) {
            $this->supervisions->add($evaluation);
        }

        return $this;
    }
}