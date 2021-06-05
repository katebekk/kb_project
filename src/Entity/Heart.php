<?php

namespace App\Entity;

use App\Repository\HeartRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HeartRepository::class)
 */
class Heart
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateHeart;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="hearts")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $post;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="hearts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateHeart(): ?\DateTimeInterface
    {
        return $this->dateHeart;
    }

    public function setDateHeart(\DateTimeInterface $dateHeart): self
    {
        $this->dateHeart = $dateHeart;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


}
