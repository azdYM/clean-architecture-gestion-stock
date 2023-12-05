<?php

namespace App\Infrastructure\Subscribers\Credit;

use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Credit\Event\CreditCanceledEvent;
use App\Domain\Notification\Entity\Notification;
use App\Domain\Notification\NotificationService;
use App\Domain\Notification\Repository\NotificationRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CreditCanceledSubscriber implements EventSubscriberInterface
{
    private CreditCanceledEvent $event;

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
            CreditCanceledEvent::class => 'onNotify'
        ];
    }

    public function onNotify(CreditCanceledEvent $event): void
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
        return 'On verra plus tard';
    }

    private function getMessage(): string
    {
        return "je ne sais pas quoi ecrire ! Aidez moi s'il vous plait";
    }
    
}