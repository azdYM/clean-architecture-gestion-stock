<?php

namespace App\Domain\Customer\Entity;

use App\Domain\Customer\Repository\IndividualRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Individual représente les individus dans le système. Elle est utilisée pour gérer les informations 
 * spécifiques aux personnes physiques et les actions liées à ces individus dans le processus de gestion de crédits.
 */
#[ORM\Entity(repositoryClass: IndividualRepository::class)]
class Individual extends Person
{
    #[ORM\Column(name: 'nick_name', length: 100, nullable: true)]
    private ?string $nickname = null;

    #[ORM\Column(length: 1)]
    private ?string $gender = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profession = null;

    #[ORM\Column(type: 'datetime', name: 'brith_day')]
    private ?\DateTimeInterface $birthDay = null;

    #[ORM\OneToOne(targetEntity:Location::class)]
    private ?Location $birthLocation = null;
    
    #[ORM\Column(type: 'integer', unique: true)]
    private ?int $nin = null;

    #[ORM\OneToOne(targetEntity:MatrimonialStatus::class, cascade: ['persist', 'remove'])]
    private ?MatrimonialStatus $matrimonialStatus = null;

    #[ORM\Column(type: 'datetime', name: 'membership_at')]
    private ?DateTimeInterface $membershipAt;

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;
        return $this;
    }

    public function getGender(): string 
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    public function getProfession(): string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): self
    {
        $this->profession = $profession;
        return $this;
    }

    public function getBirthDay(): DateTimeInterface
    {
        return $this->birthDay;
    }

    public function setBirthDay(DateTimeInterface $birthDay): self
    {
        $this->birthDay = $birthDay;
        return $this;
    }

    public function getBirthLocation(): Location
    {
        return $this->birthLocation;
    }

    public function setBirthLocation(Location $birthLocation): self
    {
        $this->birthLocation = $birthLocation;
        return $this;
    }

    public function getNin(): int
    {
        return $this->nin;
    }

    public function setNin(int $nin): self
    {
        $this->nin = $nin;
        return $this;
    }

    public function getMatrimonialStatus(): MatrimonialStatus
    {
        return $this->matrimonialStatus;
    }

    public function setMatrimonialStatus(MatrimonialStatus $matrimonialStatus): self
    {
        $this->matrimonialStatus = $matrimonialStatus;
        return $this;
    }

    public function getMembershipAt(): DateTimeInterface
    {
        return $this->membershipAt;
    }

    public function setMembershipAt(DateTimeInterface $membershipAt): self
    {
        $this->membershipAt = $membershipAt;
        return $this;
    }
}