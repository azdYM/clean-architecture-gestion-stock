<?php

namespace App\Domain\Notification\Entity;

use App\Domain\Employee\Employee;

class Notification
{
    private ?int $id = null;

    private ?Employee $employee = null;

    private string $message;

    private ?string $url = null;

    private \DateTimeInterface $createdAt;

    private ?string $channel = 'public';

    private ?string $target = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(Employee $employee): self
    {
        $this->employee = $employee;
        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getChannel(): ?string
    {
        return $this->channel;
    }

    public function setChannel(string $channel): self
    {
        $this->channel = $channel;
        return $this;
    }

    public function setUrl(string $url): self
    {
        return $this->url = $url;
        return $this;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getTarget(): ?string
    {
        return $this->target;
    }

    public function setTarget(string $target): self
    {
        $this->target = $target;
        return $this;
    }

    public function isRead(): bool
    {
        if (null === $this->employee) {
            return false;
        }

        $notificationReadAt = $this->employee->getNotificationReadAt();
        return $notificationReadAt ? ($this->getCreatedAt() > $notificationReadAt) : false;
    }
}