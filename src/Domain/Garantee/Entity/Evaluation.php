<?php


namespace App\Domain\Garantee\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Employee\Entity\Sealer;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Garantee\GaranteeInterface;
use App\Domain\Garantee\EvaluationInterface;
use App\Domain\Employee\Entity\GaranteeEvaluator;
use App\Domain\Garantee\Entity\CollateralGarantee;
use App\Domain\Garantee\Repository\EvaluationRepository;

#[ORM\Entity(repositoryClass: EvaluationRepository::class)]
class Evaluation implements EvaluationInterface
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $evaluatedAt;

    #[ORM\ManyToOne(targetEntity: CollateralGarantee::class, inversedBy: 'evaluations')]
    #[ORM\JoinColumn(name: 'garantee_id', referencedColumnName: 'id')]
    private ?GaranteeInterface $garanteeEvaluated = null;

    #[ORM\ManyToOne(targetEntity: GaranteeEvaluator::class, inversedBy: 'supervisions')]
    #[ORM\JoinColumn(name: 'evaluator_id', referencedColumnName: 'id')]
    private ?GaranteeEvaluator $evaluator = null;

    #[ORM\Column(type: 'text')]
    private ?string $descriptionEvaluator = null;
    
    #[ORM\ManyToOne(targetEntity: Sealer::class, inversedBy: 'supervisions')]
    #[ORM\JoinColumn(name: 'sealer_id', referencedColumnName: 'id')]
    private ?Sealer $sealer = null;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private ?bool $sealed = false;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $sealedAt = null;

    #[ORM\Column(type: 'text')]
    private ?string $descriptionSealer = null;

    public function __construct()
    {
        $this->evaluatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvaluatedAt(): ?\DateTimeInterface
    {
        return $this->evaluatedAt;
    }

    public function getEvaluator(): ?GaranteeEvaluator
    {
        return $this->evaluator;
    }

    public function setEvaluator(Employee $evaluator): self 
    {
        $this->evaluator = $evaluator;
        return $this;
    }

    public function getDescriptionEvaluator(): ?string
    {
        return $this->descriptionEvaluator;
    }

    public function setDescriptionEvaluator(?string $description): self
    {
        $this->descriptionSealer = $description;
        return $this;
    }

    public function getGaranteeEvaluated(): ?GaranteeInterface
    {
        return $this->garanteeEvaluated;
    }

    public function setGaranteeEvaluated(GaranteeInterface $garantee): self
    {
        $this->garanteeEvaluated = $garantee;
        return $this;
    }

    public function getSealer(): Employee
    {
        return $this->sealer;
    }

    public function setSealer(Employee $sealer): self
    {
        $this->sealer = $sealer;
        return $this;
    }

    public function getDescriptionSealer(): ?string
    {
        return $this->descriptionSealer;
    }

    public function setDescriptionSealer(?string $description): self
    {
        $this->descriptionSealer = $description;
        return $this;
    }

    public function isSealed(): bool
    {
        return $this->sealed;
    }

    public function setSealed(bool $sealed): self
    {
        $this->sealed = $sealed;
        return $this;
    }

    public function getSealedAt(): ?\DateTimeInterface
    {
        return $this->sealedAt;
    }

    public function setSealedAt(\DateTimeInterface $sealedAt): self
    {
        $this->sealedAt = $sealedAt;
        return $this;
    }
}