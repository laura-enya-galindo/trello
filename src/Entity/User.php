<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

// Pour pouvoir ajouter des contraintes sur les input dans le formulaire UserType sur UserController
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email(['message' => 'The email "{{ value }}" is not a valid email.'])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(['min' => 2, 'max' => 50, 'minMessage' => 'The first name must be at least {{ limit }} characters long', 'maxMessage' => 'The first name cannot be longer than {{ limit }} characters'])]
    private ?string $first_name = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(['min' => 2, 'max' => 50, 'minMessage' => 'The last name must be at least {{ limit }} characters long', 'maxMessage' => 'The last name cannot be longer than {{ limit }} characters'])]
    private ?string $last_name = null;

    #[ORM\ManyToMany(targetEntity: Task::class, inversedBy: 'users')]
    private Collection $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        $this->tasks->removeElement($task);

        return $this;
    }
    
}
