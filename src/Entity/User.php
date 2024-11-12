<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    private string $name;

    #[ORM\Column(type: "string", length: 255, unique: true)]
    private string $email;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $createdAt;

    #[ORM\OneToMany(targetEntity: "App\Entity\Story", mappedBy: "user")]
    private Collection $stories;

    public function __construct()
    {
        $this->stories = new ArrayCollection();
        $this->createdAt = new \DateTime(); // Initialisation de createdAt à la date actuelle
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getStories(): Collection
    {
        return $this->stories;
    }

    public function addStory(Story $story): self
    {
        if (!$this->stories->contains($story)) {
            $this->stories[] = $story;
            $story->setUser($this);
        }
        return $this;
    }

    public function removeStory(Story $story): self
    {
        if ($this->stories->contains($story)) {
            $this->stories->removeElement($story);
            // set the owning side to null (unless already changed)
            if ($story->getUser() === $this) {
                $story->setUser(null);
            }
        }
        return $this;
    }
}
