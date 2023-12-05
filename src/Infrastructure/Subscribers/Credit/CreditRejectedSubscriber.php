<?php

namespace App\Infrastructure\Subscribers\Credit;

use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Credit\Event\CreditCreatedEvent;
use App\Domain\Credit\Event\CreditRejectedEvent;
use App\Domain\Notification\Entity\Notification;
use App\Domain\Notification\NotificationService;
use App\Domain\Notification\Repository\NotificationRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CreditRejectedSubscriber implements EventSubscriberInterface
{
    private CreditRejectedEvent $event;

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
            CreditRejectedEvent::class => 'onNotify'
        ];
    }

    public function onNotify(CreditRejectedEvent $event): void
    {
        $this->event = $event;

        $attestation = $this->event->getCredit();
        $repository = $this->em->getRepository(Notification::class);
        $notification = $this->notifier->notifyChannel(
            $this->getChannel(),
            $this->getMessage(), 
            $attestation
        );
        
        $repository->persistOrUpdate($notification);
    }

    private function getChannel(): string
    {
        
        return 'On verra ça plus tard';
    }

    private function getMessage(): string
    {
        return "je ne sais pas quoi ecrire ! Aidez moi s'il vous plait";
    }
    
}