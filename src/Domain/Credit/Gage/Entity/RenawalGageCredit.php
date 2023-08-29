<?php

namespace App\Domain\Credit\Gage\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Mounting\FolderInterface;
use App\Domain\Mounting\Entity\GageFolder;
use App\Domain\Credit\Gage\Entity\GageCredit;
use App\Domain\Application\Entity\TimestampTrait;
use App\Domain\Application\Entity\IdentifiableTrait;
use App\Domain\Credit\Gage\Repository\RenawalGageCreditRepository;

#[ORM\Entity(repositoryClass: RenawalGageCreditRepository::class)]
class RenawalGageCredit
{
    use IdentifiableTrait;
    use TimestampTrait;

    #[ORM\OneToOne(targetEntity: GageCredit::class)]
    #[ORM\JoinColumn(name: 'old_credit_id', referencedColumnName: 'id')]
    private ?GageCredit $oldCredit;

    #[ORM\OneToOne(targetEntity: GageCredit::class)]
    #[ORM\JoinColumn(name: 'new_credit_id', referencedColumnName: 'id')]
    private ?GageCredit $newCredit;


    #[ORM\ManyToOne(targetEntity: GageFolder::class, inversedBy: 'renawaledCredits')]
    #[ORM\JoinColumn(name: 'folder_id', referencedColumnName: 'id')]
    private ?FolderInterface $folder = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getOldCredit(): GageCredit
    {
        return $this->oldCredit;
    }

    public function setOldCredit(GageCredit $oldCredit): self
    {
        $this->oldCredit = $oldCredit;
        return $this;
    }

    public function getNewCredit(): GageCredit
    {
        return $this->newCredit;
    }

    public function setNewCredit(GageCredit $newCredit): self
    {
        $this->newCredit = $newCredit;
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
}