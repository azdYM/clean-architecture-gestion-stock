<?php

namespace App\Domain\Credit;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Mounting\ActionOnCreditTrait;
use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\Application\Entity\TimestampTrait;
use App\Domain\Application\Entity\IdentifiableTrait;
use App\Domain\Mounting\Entity\ApprovalTrait;
use App\Domain\Mounting\Entity\RejectionTrait;

#[ORM\MappedSuperclass]
abstract class Credit implements CreditInterface
{
    use IdentifiableTrait;
    use ApprovalTrait;
    use RejectionTrait;
    use ActionOnCreditTrait;
    use TimestampTrait;

    public function __construct()
    {
        $this->approvals = new ArrayCollection();
        $this->rejections = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }    
}