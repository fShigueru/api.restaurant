<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MealRepository")
 */
class Meal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="meal")
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VariationMeal", mappedBy="meal", orphanRemoval=true, fetch="EXTRA_LAZY")
     */
    private $variation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Restaurant", inversedBy="meal")
     */
    private $restaurant;

    public function __construct()
    {
        $this->variation = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }


    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     * @return Meal
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return Collection|VariationMeal[]
     */
    public function getVariation(): Collection
    {
        return $this->variation;
    }

    public function addVariation(VariationMeal $variation): self
    {
        if (!$this->variation->contains($variation)) {
            $this->variation[] = $variation;
            $variation->setMeal($this);
        }

        return $this;
    }

    public function removeVariation(VariationMeal $variation): self
    {
        if ($this->variation->contains($variation)) {
            $this->variation->removeElement($variation);
            // set the owning side to null (unless already changed)
            if ($variation->getMeal() === $this) {
                $variation->setMeal(null);
            }
        }

        return $this;
    }

    public function extractVariation()
    {

    }

}
