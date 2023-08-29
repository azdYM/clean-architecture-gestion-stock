<?php

namespace App\Domain\Mounting\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Employee\Entity\Agency;
use App\Domain\Mounting\Entity\MountingSection;
use App\Domain\Application\Entity\IdentifiableTrait;
use App\Domain\Mounting\Repository\MountingCreditFolderServiceRepository;

#[ORM\Entity(repositoryClass: MountingCreditFolderServiceRepository::class)]
class MountingCreditFolderService
{
    use IdentifiableTrait;

    #[ORM\Column(length: 100, unique: true)]
    private ?string $serviceName;

    #[ORM\ManyToOne(targetEntity: Agency::class, inversedBy: 'mountingCreditFolderServices')]
    #[ORM\JoinColumn(name: 'agency_id', referencedColumnName: 'id')]
    private ?Agency $agency = null;

    #[ORM\OneToOne(targetEntity: MountingSection::class, inversedBy: 'evaluationGageService')]
    #[ORM\JoinColumn(name: 'section_id', referencedColumnName: 'id')]
    private ?MountingSection $section = null;

    public function getAgency(): ?Agency
    {
        return $this->agency;
    }

    public function setAgency(Agency $agency): self
    {
        $this->agency = $agency;
        return $this;
    }

    public function getSection(): ?MountingSection
    {
        return $this->section;
    }

    public function setSection(MountingSection $section): self
    {
        $this->section = $section;
        return $this;
    }

    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    public function setServiceName(string $serviceName): self
    {
        $this->serviceName = $serviceName;
        return $this;
    }
}