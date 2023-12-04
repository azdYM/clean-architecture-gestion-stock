<?php

namespace App\Domain\Notification\Entity;

use App\Domain\Auth\User;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Application\Entity\TimestampTrait;
use App\Domain\Application\Entity\IdentifiableTrait;
use Symfony\Component\Validator\Constraints as Assert;
use App\Domain\Notification\Repository\NotificationRepository;


#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    use IdentifiableTrait;
    use TimestampTrait;

    #[ORM\ManyToOne(targetEntity: \App\Domain\Auth\User::class)]
    #[ORM\JoinColumn(name: 'user_id', onDelete: 'CASCADE', nullable: true)]
    private ?User $user = null;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    private string $message;

    #[ORM\Column(type: 'string', nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Url]
    private ?string $url = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $channel = 'public';

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $target = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
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
        $this->url = $url;
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
        if (null === $this->user) {
            return false;
        }

        $notificationReadAt = $this->user->getNotificationReadAt();
        return $notificationReadAt ? ($this->getCreatedAt() > $notificationReadAt) : false;
    }
}