<?php

namespace App\Tests\Domain\Credit;

use App\Domain\Credit\Entity\ShortTerm\GageCredit;
use App\Domain\Employee\Service\CreditMountingService;
use Symfony\Component\EventDispatcher\EventDispatcher;
use App\Domain\Credit\Service\GageCreditCreationService;


trait CreationCreditTrait
{
    private function createGageCredit(): GageCredit
    {
        $employeeService = new CreditMountingService($this->creditAgent, new EventDispatcher);
        $creditCreationService = new GageCreditCreationService($this->folder);
        return $employeeService->createCredit($creditCreationService, $this->requirements);
    }
}