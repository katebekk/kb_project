<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
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
    private $dateOfCreation;

    /**
     * @ORM\Column(type="string", length=300, nullable=true)
     */
    private $description;


    /**
     * @ORM\Column(type="object")
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="post")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img;

    /**
     * @ORM\OneToMany(targetEntity=Heart::class, mappedBy="post")
     */
    private $hearts;

    public function __construct()
    {
        $this->hearts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateOfCreation(): ?\DateTimeInterface
    {
        return $this->dateOfCreation;
    }

    public function setDateOfCreation(\DateTimeInterface $dateOfCreation): self
    {
        $this->dateOfCreation = $dateOfCreation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }


    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

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

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    /**
     * @return Collection|Heart[]
     */
    public function getHearts(): Collection
    {
        return $this->hearts;
    }

    public function addHeart(Heart $heart): self
    {
        if (!$this->hearts->contains($heart)) {
            $this->hearts[] = $heart;
            $heart->setPost($this);
        }

        return $this;
    }

    public function removeHeart(Heart $heart): self
    {
        if ($this->hearts->contains($heart)) {
            $this->hearts->removeElement($heart);
            // set the owning side to null (unless already changed)
            if ($heart->getPost() === $this) {
                $heart->setPost(null);
            }
        }

        return $this;
    }
}
