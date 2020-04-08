<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * attributes={"force_eager"=false,"normalization_context": {"groups"={"user_read"}, "enable_max_depth"=true}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 * @ApiFilter(SearchFilter::class, properties={"id": "exact", "nom": "exact"})
 */
class Categorie
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
     * @Groups("user_read")
     * @ORM\ManyToMany(targetEntity="App\Entity\Produit", inversedBy="categories")
     */
    private $produit;

    public function __construct()
    {
        $this->produit = new ArrayCollection();
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

    /**
     * @return Collection|Produit[]
     */
    public function getProduit(): Collection
    {
        return $this->produit;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produit->contains($produit)) {
            $this->produit[] = $produit;
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produit->contains($produit)) {
            $this->produit->removeElement($produit);
        }

        return $this;
    }
}
