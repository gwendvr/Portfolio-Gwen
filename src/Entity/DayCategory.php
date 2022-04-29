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

    #[ORM\OneToMany(mappedBy: 'day', targetEntity: Tag::class)]
    private $tag;

    public function __construct()
    {
        $this->task = new ArrayCollection();
        $this->dayTask = new ArrayCollection();
        $this->tag = new ArrayCollection();
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

    /**
     * @return Collection<int, Task>
     */
    public function getDayTask(): Collection
    {
        return $this->dayTask;
    }

    public function addDayTask(Tasks $dayTask): self
    {
        if (!$this->dayTask->contains($dayTask)) {
            $this->dayTask[] = $dayTask;
            $dayTask->setDay($this);
        }

        return $this;
    }

    public function removeDayTask(Tasks $dayTask): self
    {
        if ($this->dayTask->removeElement($dayTask)) {
            // set the owning side to null (unless already changed)
            if ($dayTask->getDay() === $this) {
                $dayTask->setDay(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tag->contains($tag)) {
            $this->tag[] = $tag;
            $tag->setDay($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tag->removeElement($tag)) {
            // set the owning side to null (unless already changed)
            if ($tag->getDay() === $this) {
                $tag->setDay(null);
            }
        }

        return $this;
    }
}