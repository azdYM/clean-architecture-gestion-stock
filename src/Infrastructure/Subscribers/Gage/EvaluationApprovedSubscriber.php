<?php

namespace App\Infrastructure\Subscribers\Gage;

use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Notification\NotificationService;
use App\Domain\Garantee\Event\EvaluationApprovedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EvaluationApprovedSubscriber implements EventSubscriberInterface
{
    private EvaluationApprovedEvent $event;

    public function __construct(
        private EntityManagerInterface $em,
        private NotificationService $notifier,
    ){}

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return 
        [
            EvaluationApprovedEvent::class => 'onNotify',
        ];
    }

    public function onNotify(EvaluationApprovedEvent $event): void
    {
        $this->event = $event;
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
        $section = $this->event->getSectionLabel();
        $agency = $this->event->getAgencyLabel();
        return 'agents_credit_'.$section.'_'.$agency;
    }

    private function getMessage(): string
    {
        return "je ne sais pas quoi ecrire ! Aidez moi s'il vous plait";
    }
}