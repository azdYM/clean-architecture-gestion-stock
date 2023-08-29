<?php

namespace App\Infrastructure\Subscribers\Gage;

use App\Domain\Garantee\Event\EvaluationCanceledEvent;
use App\Domain\Garantee\Gold\Entity\Evaluator;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Notification\NotificationService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EvaluationCanceledSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EvaluationCanceledEvent $event, 
        private EntityManagerInterface $em,
        private NotificationService $notifier
    ){}

    public static function getSubscribedEvents()
    {
        return 
        [
            EvaluationCanceledEvent::class => 'onNotify'
        ];
    }

    public function onNotify(): void
    {
        $attestation = $this->event->getAttestation();
        /** @var Evaluator $evaluator */
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