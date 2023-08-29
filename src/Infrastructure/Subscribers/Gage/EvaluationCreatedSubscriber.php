<?php

namespace App\Infrastructure\Subscribers\Gage;

use App\Domain\Garantee\Event\EvaluationCreatedEvent;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Notification\NotificationService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EvaluationCreatedSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EvaluationCreatedEvent $event, 
        private EntityManagerInterface $em,
        private NotificationService $notifier
    ){}

    public static function getSubscribedEvents()
    {
        return 
        [
            EvaluationCreatedEvent::class => 'onNotify'
        ];
    }

    public function onNotify(): void
    {
        $attestation = $this->event->getAttestation();
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
        $section = $this->event->getSectionLabel();
        return 'supervisors_evaluation_'.$section.'_'.$agency;
    }

    private function getMessage(): string
    {
        return "je ne sais pas quoi ecrire ! Aidez moi s'il vous plait";
    }
}