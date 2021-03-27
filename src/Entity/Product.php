<?php

// Consulter la liste des produits BileMo -> GET /api/products
// Consulter les détails d’un produit BileMo -> GET /api/products/{id}

// NOTE ! ON NE NOUS DEMANDE PAS D'AJOUTER, DE MODIFIER OU DE SUPPRIMER DES PRODUITS
// NOTE ! RETIRER PUT, PATCH, DELETE ET POST DES OPERATIONS...?

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;

// On peut ajouter cette annotation dans la section ApiResource()
// shortName="Téléphones",
// Pour changer le nom des routes..

/**
 * @ApiResource(
 * attributes={
 *      "order"={"id":"DESC"}
 * },
 * itemOperations={
 *      "get"={
 *          "openapi_context" = {
 * 				"summary" = "View the details of a product",
 *              "description" = "Query to display a Bilemo product"
 *           }
 *      },
 *      "put"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Operation reserved for administrators"
 *      },
 *      "patch"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Operation reserved for administrators"
 *      },
 *      "delete"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Operation reserved for administrators"
 *      }
 *  },
 *  collectionOperations={
 *      "get"={
 *          "openapi_context" = {
 * 				"summary" = "Consult the product list",
 *              "description" = "Query to display all Bilemo products"
 *           }
 *      },
 *      "post"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Operation reserved for administrators"
 *      }
 *  }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * 
     * @ORM\GeneratedValue()
     * 
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80, unique=true)
     * 
     * @Assert\NotBlank
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=80)
     * 
     * @Assert\NotBlank
     */
    private $trademark;

    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank
     */
    private $summary;

    /**
     * @ORM\Column(type="string", length=40)
     * 
     * @Assert\NotBlank
     */
    private $color;

    /**
     * @ORM\Column(type="float")
     * 
     * @Assert\NotBlank
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Assert\NotBlank
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getTrademark(): ?string
    {
        return $this->trademark;
    }

    public function setTrademark(string $trademark): self
    {
        $this->trademark = $trademark;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

 

}
