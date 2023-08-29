<?php

namespace App\Infrastructure\Subscribers\Credit;

use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Credit\Event\CreditCreatedEvent;
use App\Domain\Notification\NotificationService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CreditCreatedSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private CreditCreatedEvent $event, 
        private EntityManagerInterface $em,
        private NotificationService $notifier
    ){}

    public static function getSubscribedEvents()
    {
        return 
        [
            CreditCreatedEvent::class => 'onNotify'
        ];
    }

    public function onNotify(): void
    {
        $attestation = $this->event->getCredit();
        $repository = $this->em->getRepository(NotificationRepository::class);
        $notification = $this->notifier->notifyChannel(
            $this->getChannel(),
            $this->getMessage(), 
            $attestation
        );
        
        $repository->persistOrUpdate($notification);
    }

    private function getChannel(): string
    {
        $agency = $this->event->getAgencyLabel();
        $section = $this->event->getCreditCreationServiceName();
        return 'supervisors_credit_'.$section.'_'.$agency;
    }

    private function getMessage(): string
    {
        return "je ne sais pas quoi ecrire ! Aidez moi s'il vous plait";
    }
    
}