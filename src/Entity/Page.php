<?php

namespace App\Entity;

use App\Repository\PageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PageRepository::class)
 */
class Page
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Like::class, mappedBy="page")
     */
    private $looys;

    /**
     * @ORM\ManyToOne(targetEntity=Like::class, inversedBy="pages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $holy;

    public function __construct()
    {
        $this->looys = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Like[]
     */
    public function getLooys(): Collection
    {
        return $this->looys;
    }

    public function addLooy(Like $looy): self
    {
        if (!$this->looys->contains($looy)) {
            $this->looys[] = $looy;
            $looy->setPage($this);
        }

        return $this;
    }

    public function removeLooy(Like $looy): self
    {
        if ($this->looys->contains($looy)) {
            $this->looys->removeElement($looy);
            // set the owning side to null (unless already changed)
            if ($looy->getPage() === $this) {
                $looy->setPage(null);
            }
        }

        return $this;
    }

    public function getHoly(): ?Like
    {
        return $this->holy;
    }

    public function setHoly(?Like $holy): self
    {
        $this->holy = $holy;

        return $this;
    }
}
