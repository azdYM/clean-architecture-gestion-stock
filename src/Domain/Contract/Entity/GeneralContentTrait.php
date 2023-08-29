<?php

namespace App\Domain\Contract\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Contract\MakerContentInterface;
use App\Domain\Contract\Components\GeneralContent;

trait GeneralContentTrait
{
    #[ORM\OneToOne(targetEntity: GeneralContent::class)]
    #[ORM\JoinColumn(name: 'content_id', referencedColumnName: 'id')]
    protected ?GeneralContent $content = null;

    public function getGeneralContent(): GeneralContent
    {
        return $this->content;
    }

    public function generateAndSetGeneralContent(MakerContentInterface $creator): self
    {
        $this->content = $creator
            ->setContractType(get_called_class())
            ->generate()
        ;
        
        return $this;
    }
}