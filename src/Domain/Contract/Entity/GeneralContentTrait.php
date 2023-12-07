<?php

namespace App\Domain\Contract\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Contract\MakerContentInterface;
use Symfony\Component\Serializer\Annotation\Groups;

trait GeneralContentTrait
{
    #[ORM\Column(type: 'text')]
    #[Groups(['Credit:read'])]
    protected ?string $content = null;

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function generateAndSetContent(MakerContentInterface $creator): self
    {
        $this->content = $creator
            ->setContract($this)
            ->generate()
        ;
        
        return $this;
    }
}