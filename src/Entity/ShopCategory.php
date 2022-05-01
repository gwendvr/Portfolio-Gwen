<?php

namespace App\Entity;

use App\Repository\ShopCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShopCategoryRepository::class)]
class ShopCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 150)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Shop::class)]
    private $Shop;

    public function __construct()
    {
        $this->Shop = new ArrayCollection();
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
     * @return Collection<int, Shop>
     */
    public function getShop(): Collection
    {
        return $this->Shop;
    }

    public function addShop(Shop $shop): self
    {
        if (!$this->Shop->contains($shop)) {
            $this->Shop[] = $shop;
            $shop->setCategory($this);
        }

        return $this;
    }

    public function removeShop(Shop $shop): self
    {
        if ($this->Shop->removeElement($shop)) {
            // set the owning side to null (unless already changed)
            if ($shop->getCategory() === $this) {
                $shop->setCategory(null);
            }
        }

        return $this;
    }
}
