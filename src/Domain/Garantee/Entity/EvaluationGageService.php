<?php

namespace App\Domain\Garantee\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Employee\Entity\Agency;
use App\Domain\Garantee\Entity\GageSection;
use App\Domain\Application\Entity\TimestampTrait;
use App\Domain\Application\Entity\IdentifiableTrait;
use App\Domain\Garantee\Repository\EvaluationGageServiceRepository;

#[ORM\Entity(repositoryClass: EvaluationGageServiceRepository::class)]
class EvaluationGageService 
{
    use IdentifiableTrait;
    use TimestampTrait;

    #[ORM\Column(length: 100, unique: true)]
    private ?string $serviceName = null;

    #[ORM\ManyToOne(targetEntity: Agency::class, inversedBy: 'evaluationGageServices')]
    #[ORM\JoinColumn(name: 'agency_id', referencedColumnName: 'id')]
    private ?Agency $agency = null;

    #[ORM\OneToOne(targetEntity: EvaluationGageSection::class, inversedBy: 'evaluationGageService')]
    #[ORM\JoinColumn(name: 'section_id', referencedColumnName: 'id')]
    private ?EvaluationGageSection $section = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getAgency(): ?Agency
    {
        return $this->agency;
    }

    public function setAgency(Agency $agency): self
    {
        $this->agency = $agency;
        return $this;
    }

    public function getServiceName(): ?string
    {
        return $this->serviceName;
    }

    public function setServiceName(string $name): self
    {
        $this->serviceName = $name;
        return $this;
    }

    public function getSection(): EvaluationGageSection
    {
        return $this->section;
    }

    public function setSection(EvaluationGageSection $section): self
    {
        $this->section = $section;
        return $this;
    }
}