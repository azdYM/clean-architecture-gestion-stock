<?php

namespace App\Infrastructure\Subscribers\Gage;

use App\Domain\Garantee\Event\EvaluationCanceledEvent;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Notification\NotificationService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EvaluationCanceledSubscriber implements EventSubscriberInterface
{
    private EvaluationCanceledEvent $event;

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
            EvaluationCanceledEvent::class => 'onNotify'
        ];
    }

    public function onNotify(EvaluationCanceledEvent $event): void
    {
        $this->event = $event;
        $attestation = $this->event->getAttestation();
        $evaluator = $attestation->getEvaluator();
        $repository = $this->em->getRepository(NotificationRepository::class);

        $notification = $this->notifier->notifyEmployee(
            $evaluator, 
            $this->getMessage(), 
            $attestation
        );

        $repository->persistOrUpdate($notification);
    }

    private function getMessage(): string
    {
        return "je ne sais pas quoi ecrire ! Aidez moi s'il vous plait";
    }
}