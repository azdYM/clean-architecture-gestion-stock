<?php

namespace App\Domain\Credit;

use App\Domain\Application\Entity\IdentifiableTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\CreditType\Repository\CreditTypeRepository;
use App\Domain\Mounting\Entity\MountingSection;

#[ORM\Entity(repositoryClass: CreditTypeRepository::class)]
class CreditType {

    use IdentifiableTrait;

    #[ORM\Column(length: 100)]
    private ?string $label = null;

    /**
     * Le nom de la classe 
     * @var string|null
     */
    #[ORM\Column(unique: true, length: 50)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: MountingSection::class, inversedBy: 'loans')]
    #[ORM\JoinColumn(name: 'section_id')]
    private ?MountingSection $mountingSection = null;

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function getMountingSection(): ?MountingSection
    {
        return $this->mountingSection;
    }

    public function setMountingSection(MountingSection $section): self
    {
        $this->mountingSection = $section;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    const GAGE = "gage";
}