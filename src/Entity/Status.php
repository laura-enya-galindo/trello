<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $label = null;

    #[ORM\OneToMany(mappedBy: 'status', targetEntity: Task::class, orphanRemoval: true)]
    private Collection $task;

    public function __construct()
    {
        $this->task = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTask(): Collection
    {
        return $this->task;
    }

    public function addTask(Task $task): self
    {
        if (!$this->task->contains($task)) {
            $this->task->add($task);
            $task->setStatus($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->task->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getStatus() === $this) {
                $task->setStatus(null);
            }
        }

        return $this;
    }
}
