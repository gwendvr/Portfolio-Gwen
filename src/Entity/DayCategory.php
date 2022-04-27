<?php

namespace App\Entity;

use App\Repository\DayCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DayCategoryRepository::class)]
class DayCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 150)]
    private $day;

    #[ORM\OneToMany(mappedBy: 'day', targetEntity: Tasks::class)]
    private $task;

    public function __construct()
    {
        $this->task = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): self
    {
        $this->day = $day;

        return $this;
    }

    /**
     * @return Collection<int, Tasks>
     */
    public function getTask(): Collection
    {
        return $this->task;
    }

    public function addTask(Tasks $task): self
    {
        if (!$this->task->contains($task)) {
            $this->task[] = $task;
            $task->setDay($this);
        }

        return $this;
    }

    public function removeTask(Tasks $task): self
    {
        if ($this->task->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getDay() === $this) {
                $task->setDay(null);
            }
        }

        return $this;
    }
}
