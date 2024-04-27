<?php

namespace App\Domain\Garantee\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Customer\Entity\Person;
use App\Domain\Credit\Entity\CreditType;
use App\Domain\Customer\ClientInterface;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Garantee\EvaluationTrait;
use App\Domain\Mounting\FolderInterface;
use App\Domain\Mounting\Entity\CreditFolder;
use App\Domain\Garantee\AttestationInterface;
use App\Domain\Garantee\AttestationActionsTrait;
use App\Domain\Application\Entity\TimestampTrait;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Domain\Application\Entity\IdentifiableTrait;
use App\Domain\Garantee\Entity\Gold\GoldAttestation;


#[ORM\Entity]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap([
    'generic' => GaranteeAttestation::class,
    'gold' => GoldAttestation::class,
    // Ajout d'une nouvelle attestation
])]
abstract class GaranteeAttestation implements AttestationInterface
{
    use IdentifiableTrait;
    use TimestampTrait;
    use EvaluationTrait;
    use ApprovalTrait;
    use RejectionTrait;
    use AttestationActionsTrait;

    const ATTESTATION_APPROVED  = 'approved';
    const ATTESTATION_EVALUATED = 'evaluated';
    const ATTESTATION_REJECTED  = 'rejected';

    /**
     * Utilisé pour savoir l'état actuel de l'attestation
     */
    #[ORM\Column(type: 'string', options: ['default' => 'created'])]
    protected ?string $currentPlace = 'created';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $evaluatorDescription = null;

    #[ORM\ManyToOne(targetEntity: Person::class)]
    #[ORM\JoinColumn(name: 'client_id', referencedColumnName: 'id')]
    #[Groups(['GoldEvaluation:read'])]
    protected ClientInterface $client;

    #[ORM\ManyToOne(targetEntity: CreditFolder::class, inversedBy: 'attestations')]
    #[ORM\JoinColumn(name: 'folder_id', referencedColumnName: 'id')]
    protected ?CreditFolder $folder = null;

    #[ORM\ManyToOne(targetEntity: CreditType::class)]
    #[ORM\JoinColumn(name: 'credit_type_id', referencedColumnName: 'id')]
    #[Groups(['GoldEvaluation:read'])]
    protected ?CreditType $creditTypeTargeted = null;

    #[ORM\ManyToOne(targetEntity: EvaluationGageService::class)]
    #[ORM\JoinColumn(name: 'evaluation_service_id', referencedColumnName: 'id')]
    protected ?EvaluationGageService $evaluationService = null;

    #[ORM\ManyToOne(targetEntity: Employee::class)]
    #[ORM\JoinColumn(name: 'evaluator_id', referencedColumnName: 'id')]
    protected Employee $evaluator;

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    public function setClient(ClientInterface $client): static
    {
        $this->client = $client;
        return $this;
    }

    public function getCurrentPlace(): string
    {
        return $this->currentPlace;
    }

    public function setCurrentPlace(string $currentPlace): self 
    {
        $this->currentPlace = $currentPlace;
        return $this;
    }

    public function getCreditTypeTargeted(): ?CreditType
    {
        return $this->creditTypeTargeted;
    }

    public function setCreditTypeTargeted(CreditType $creditType): self
    {
        $this->creditTypeTargeted = $creditType;
        return $this;
    }

    public function getFolder(): ?FolderInterface 
    {
        return $this->folder;
    }

    public function setFolder(FolderInterface $folder): self
    {
        $this->folder = $folder;
        return $this;
    }

    public function getEvaluationService(): ?EvaluationGageService
    {
        return $this->evaluationService;
    }

    public function setEvaluationService(EvaluationGageService $evaluationService): self
    {
        $this->evaluationService = $evaluationService;
        return $this;
    }
}