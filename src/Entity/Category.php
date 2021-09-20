<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Article::class, mappedBy="category")
     */
    private $category;



    public function __construct()
    {
        $this->category = new ArrayCollection();
    }

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

    /**
     * @return Collection|Article[]
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Article $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
            $category->addCategory($this);
        }

        return $this;
    }

    public function removeCategory(Article $category): self
    {
        if ($this->category->removeElement($category)) {
            $category->removeCategory($this);
        }

        return $this;
    }


}
