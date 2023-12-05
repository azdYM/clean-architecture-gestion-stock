<?php

namespace App\Infrastructure\Subscribers\Credit;

use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Credit\Event\CreditCreatedEvent;
use App\Domain\Notification\Entity\Notification;
use App\Domain\Notification\NotificationService;
use App\Domain\Notification\Repository\NotificationRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CreditCreatedSubscriber implements EventSubscriberInterface
{
    private CreditCreatedEvent $event;

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
            CreditCreatedEvent::class => 'onNotify'
        ];
    }

    public function onNotify(CreditCreatedEvent $event): void
    {
        $this->event = $event;
        $credit = $this->event->getCredit();
        $repository = $this->em->getRepository(Notification::class);
        $notification = $this->notifier->notifyChannel(
            $this->getChannel(),
            $this->getMessage(), 
            $credit
        );
        
        $repository->persistOrUpdate($notification);
    }

    private function getChannel(): string
    {
        $agency = $this->event->getAgencyId();
        $section = $this->event->getCreditCreationServiceName();
        return 'supervisors_credit_'.$section.'_'.$agency;
    }

    private function getMessage(): string
    {
        return "je ne sais pas quoi ecrire ! Aidez moi s'il vous plait";
    }
    
}