<?php

namespace App\Infrastructure\Subscribers\Credit;

use App\Domain\Credit\CreditApprovedEvent;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Notification\NotificationService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CreditApprovedSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private CreditApprovedEvent $event, 
        private EntityManagerInterface $em,
        private NotificationService $notifier
    ){}

    public static function getSubscribedEvents()
    {
        return 
        [
            CreditApprovedEvent::class => 'onNotify'
        ];
    }

    public function onNotify(): void
    {
        $this->notifyCreditAgentToGenreateContract();
    }

    public function notifyCreditAgentToGenreateContract(): void
    {
        $credit = $this->event->getCredit();
        $repository = $this->em->getRepository(NotificationRepository::class);

        $notification = $this->notifier->notifyEmployee(
            $credit->getCreditAgent(),
            $this->getMessageForCreditAgent(), 
            $credit
        );

        $repository->persisOrUpdate($notification);
    }

    private function getMessageForCreditAgent(): string
    {
        return "Cette message est adressé à l'agent de crédit ! ";
    }
}