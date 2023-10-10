<?php

namespace App\Domain\Garantee\Entity\Gold;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Credit\CreditType;
use App\Domain\Garantee\ItemInterface;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Garantee\EvaluationTrait;
use App\Domain\Garantee\Entity\Gold\Gold;
use App\Domain\Mounting\Entity\GageFolder;
use App\Domain\Garantee\Entity\Attestation;
use Doctrine\Common\Collections\Collection;
use App\Domain\Garantee\Entity\ApprovalTrait;
use App\Domain\Garantee\Entity\RejectionTrait;
use App\Domain\Application\CancellableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\Application\Entity\TimestampTrait;
use App\Domain\Application\Entity\CancellableTrait;
use App\Domain\Garantee\AttestationActionsTrait;
use App\Domain\Garantee\Repository\Gold\GoldAttestationRepository;

#[ORM\Entity(repositoryClass: GoldAttestationRepository::class)]
class GoldAttestation extends Attestation implements CancellableInterface
{
    use TimestampTrait;
    use EvaluationTrait;
    use ApprovalTrait;
    use RejectionTrait;
    use AttestationActionsTrait;
    use CancellableTrait;

    /** @var Collection<int, Gold> */
    #[ORM\OneToMany(targetEntity: Gold::class, mappedBy: 'attestation')]
    private Collection $items;

    #[ORM\ManyToOne(targetEntity: Employee::class)]
    #[ORM\JoinColumn(name: 'evaluator_id', referencedColumnName: 'id')]
    private Employee $evaluator;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $evaluatorDescription = null;

    #[ORM\ManyToOne(targetEntity: CreditType::class)]
    #[ORM\JoinColumn(name: 'credit_type_id', referencedColumnName: 'id')]
    private ?CreditType $creditTypeTargeted = null;

    #[ORM\ManyToOne(targetEntity: GageFolder::class, inversedBy: 'attestations')]
    #[ORM\JoinColumn(name: 'folder_id', referencedColumnName: 'id')]
    private ?GageFolder $folder = null;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * @return Collection<int, Gold>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(ItemInterface $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
        }

        return $this;
    }

    public function removeItem(Gold $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
        }

        return $this;
    }

    public function getValorisation(): int
    {
        return $this->calculateTotalValue();
    }

    private function calculateTotalValue(): int
    {
        $totalValue = 0;

        foreach($this->items as $item) {
            $totalValue += $item->getUnitPrice();
        }

        return $totalValue;
    }

    public function getCreditTypeTargeted(): CreditType
    {
        return $this->creditTypeTargeted;
    }

    public function setCreditTypeTargeted(CreditType $creditType): self
    {
        $this->creditTypeTargeted = $creditType;
        return $this;
    }

    public static function create(): self
    {
        return new GoldAttestation();
    }
}