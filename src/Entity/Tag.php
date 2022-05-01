<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 150)]
    private $name;

    #[ORM\ManyToOne(targetEntity: DayCategory::class, inversedBy: 'tag')]
    #[ORM\JoinColumn(nullable: false)]
    private $day;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDay(): ?DayCategory
    {
        return $this->day;
    }

    public function setDay(?DayCategory $day): self
    {
        $this->day = $day;

        return $this;
    }
}
