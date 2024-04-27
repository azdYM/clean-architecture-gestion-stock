<?php

namespace App\Domain\Notification;

use App\Domain\Employee\Entity\Employee;
use App\Infrastructure\Encoder\PathEncoder;
use App\Domain\Notification\Entity\Notification;
use Symfony\Component\Serializer\SerializerInterface;
use App\Domain\Notification\Event\NotificationCreatedEvent;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class NotificationService
{
    public function __construct(
        private SerializerInterface $serializer,
        private EventDispatcherInterface $event,
    ){}

    public function notifyChannel(string $channel, string $message, ?object $entity = null): Notification
    {
        $url = $this->getUrl($entity);
        $notification = (new Notification())
            ->setChannel($channel)
            ->setMessage($message)
            ->setTarget($entity ? $this->getHashForEntity($entity) : null)
            ->setUrl($url)
        ;
        $this->event->dispatch(new NotificationCreatedEvent($notification));
        return $notification;
    }

    public function notifyEmployee(Employee $employee, string $message, object $entity): Notification
    {
        $url = $this->getUrl($entity);
        $notification = (new Notification())
            ->setUser($employee)
            ->setMessage($message)
            ->setTarget($entity ? $this->getHashForEntity($entity) : null)
            ->setUrl($url)
        ;

        $this->event->dispatch(new NotificationCreatedEvent($notification));
        return $notification;
    }

    private function getHashForEntity(object $entity): string
    {
        $hash = $entity::class;
        if (method_exists($entity, 'getId')) {
            $hash .= '::'.(string) $entity->getId();
        }

        return $hash;
    }

    private function getUrl(?object $entity) {
        if (is_null($entity)) {
            return null;
        }

        return $this->serializer->serialize($entity, PathEncoder::FORMAT, ['groups' => ['Attestation', 'Identifiant:read']]);
    } 
}