<?php

namespace App\Infrastructure\Subscribers\Credit;

use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Credit\Event\CreditApprovedEvent;
use App\Domain\Notification\Entity\Notification;
use App\Domain\Notification\NotificationService;
use App\Domain\Notification\Repository\NotificationRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CreditApprovedSubscriber implements EventSubscriberInterface
{
    private CreditApprovedEvent $event;

    public function __construct(
        private EntityManagerInterface $em,
        private NotificationService $notifier
    ){}

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return 
        [
            CreditApprovedEvent::class => 'onNotify'
        ];
    }

    public function onNotify(CreditApprovedEvent $event): void
    {
        $this->event = $event;
        $this->notifyCreditAgentToGenreateContract();
    }

    public function notifyCreditAgentToGenreateContract(): void
    {
        $credit = $this->event->getCredit();
        $repository = $this->em->getRepository(Notification::class);

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