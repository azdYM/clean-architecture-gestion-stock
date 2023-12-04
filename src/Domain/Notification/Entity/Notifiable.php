<?php

namespace App\Domain\Notification\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait Notifiable 
{
    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(['CurrentUser:read'])]
    protected ?\DateTimeInterface $notificationReadAt = null;

    public function getNotificationReadAt(): ?\DateTimeInterface
    {
        return $this->notificationReadAt;
    }

    public function setNotificationReadAt(\DateTimeInterface $notificationReadAt): self
    {
        $this->notificationReadAt = $notificationReadAt;
        return $this;
    }
}