<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *  attributes={
 *      "order"={"id":"DESC"}
 * },
 * itemOperations={
 *      "get"={
 *          "normalization_context"={
 *              "groups"={"product_details:read"}
 *          },
 *          "openapi_context" = {
 * 				"summary" = "View the details of a product",
 *              "description" = "Query to display a Bilemo product",
 *              "tags" = {"ONE PRODUCT"}
 *           }
 *      },
 *      "delete"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Operation reserved for administrators",
 *          "openapi_context" = {
 * 		        "summary" = "Delete one product",
 *              "description" = "Delete by ID one product",
 *              "tags" = {"REMOVE PRODUCT"}
 *          }
 *      }
 *  },
 *  collectionOperations={
 *      "get"={
 *          "normalization_context"={
 *              "groups"={"products:read"}
 *          },
 *          "openapi_context" = {
 * 				"summary" = "Consult the products list",
 *              "description" = "Query to display all Bilemo products",
 *              "tags" = {"ALL PRODUCTS"}
 *           }
 *      },
 *      "post"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Operation reserved for administrators",
 *          "denormalization_context"={
 *              "groups"={"products:write"}
 *          },
 *          "openapi_context" = {
 * 		        "summary" = "Creates a new product",
 *              "description" = "Creates a new Bilemo product",
 *              "tags" = {"ADD PRODUCT"}
 *          }
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
     * 
     * @Groups({"product_details:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80, unique=true)
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"product_details:read", "products:read", "products:write"})
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=80)
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"product_details:read", "products:read", "products:write"})
     */
    private $trademark;

    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"product_details:read", "products:write"})
     */
    private $summary;

    /**
     * @ORM\Column(type="string", length=40)
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"product_details:read", "products:write"})
     */
    private $color;

    /**
     * @ORM\Column(type="float")
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"product_details:read", "products:write"})
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"product_details:read"})
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

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
