<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;

/**
 * @ApiResource(attributes={"force_eager"=false,"normalization_context": {"groups"={"user_produit"}, "enable_max_depth"=true}})
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 * @ApiFilter(RangeFilter::class, properties={"prix"})
 */
class Produit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("user_read")
     * @Groups("user_produit")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user_read")
     * @Groups("user_produit")
     */
    private $nom;

    /**
     * @ORM\Column(type="text")
     * @Groups("user_read")
     * @Groups("user_produit")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Groups("user_read")
     * @Groups("user_produit")
     */
    private $prix;

    /**
     * @Groups("user_produit")
     * @ORM\ManyToMany(targetEntity="App\Entity\Categorie", mappedBy="produit")
     */
    private $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addProduit($this);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            $category->removeProduit($this);
        }

        return $this;
    }
}
