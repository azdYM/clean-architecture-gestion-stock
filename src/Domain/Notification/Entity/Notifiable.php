<?php

namespace App\Domain\Notification\Entity;

trait Notifiable 
{
    private ?\DateTimeInterface $notificationReadAt = null;

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