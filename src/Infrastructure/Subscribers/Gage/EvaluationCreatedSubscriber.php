<?php

namespace App\Infrastructure\Subscribers\Gage;

use App\Domain\Employee\Entity\Agency;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Notification\Entity\Notification;
use App\Domain\Notification\NotificationService;
use App\Domain\Garantee\Event\EvaluationCreatedEvent;
use App\Domain\Notification\Repository\NotificationRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EvaluationCreatedSubscriber implements EventSubscriberInterface
{
    private EvaluationCreatedEvent $event;

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
            EvaluationCreatedEvent::class => 'onNotify'
        ];
    }

    public function onNotify(EvaluationCreatedEvent $event): void
    {
        $this->event = $event;
        $attestation = $this->event->getAttestation();
        /** @var NotificationRepository $repository */
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
        $section = $this->event->getSectionLabel();
        $agency = $this->event->getAgency();
        return 'supervisors_evaluation_'.$section.'_'.$agency;
    }

    private function getMessage(): string
    {
        return "je ne sais pas quoi ecrire ! Aidez moi s'il vous plait";
    }
}