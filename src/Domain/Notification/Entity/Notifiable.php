<?php

namespace App\Domain\Notification\Entity;
use Doctrine\ORM\Mapping as ORM;

trait Notifiable 
{
    #[ORM\Column(type: 'datetime', nullable: true)]
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