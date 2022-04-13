<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\ManyToOne(targetEntity: TableauCompetence::class, inversedBy: 'Category')]
    #[ORM\JoinColumn(nullable: true)]
    private $TableauCompetence;

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

    public function getTableauCompetence(): ?TableauCompetence
    {
        return $this->TableauCompetence;
    }

    public function setTableauCompetence(?TableauCompetence $TableauCompetence): self
    {
        $this->TableauCompetence = $TableauCompetence;

        return $this;
    }
}
