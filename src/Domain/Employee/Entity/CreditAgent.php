<?php

namespace App\Domain\Employee\Entity;

use App\Domain\Employee\ROLE;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Mounting\Entity\Folder;
use App\Domain\Customer\ClientInterface;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Mounting\FolderInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\Application\FolderCreatorInterface;
use App\Domain\CreditAgent\Repository\CreditAgentRepository;

#[ORM\Entity(repositoryClass: CreditAgentRepository::class)]
class CreditAgent extends Employee
{
    /**
     * @var Collection<int, FolderInterface>
     */
    #[ORM\OneToMany(targetEntity: Folder::class, mappedBy: 'creditAgent', cascade: ['persist'])]
    protected Collection $folders;

    public function __construct()
    {
        parent::__construct();
        $this->folders = new ArrayCollection();
    }

    public function setRoles(array $roles): static
    {
        parent::setRoles([ROLE::CREDIT_AGENT]);
        return $this;
    }

    public function getFolders(): Collection
    {
        return $this->folders;
    }

    public function mount(FolderCreatorInterface $creator, ClientInterface $client, Collection $garantees
    ): self
    {
        $folder = $creator
            ->setClient($client)
            ->setGarantees($garantees)
            ->create()
        ;

        $this->addFolder($folder);
        return $this;
    }

    private function addFolder(FolderInterface $folder): void
    {
        if (!$this->folders->contains($folder)) {
            $this->folders->add($folder);
        }
    }
}