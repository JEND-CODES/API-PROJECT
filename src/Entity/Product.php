<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use App\Controller\Operations\NewProductMailer;

/**
 * @ApiResource(
 *  attributes = {
 *      "order" = {"id":"DESC"}
 *  },
 *  paginationItemsPerPage = 4,
 *  itemOperations = {
 *      "get" = {
 *          "normalization_context" = {
 *              "groups" = {"product_details:read"}
 *          },
 *          "openapi_context" = {
 *              "summary" = "Displays product details",
 *              "description" = "Query to display a Bilemo product"
 *           }
 *      },
 *      "delete" = {
 *          "security" = "is_granted('ROLE_SUPER_ADMIN')",
 *          "security_message" = "Operation restricted to managers",
 *          "openapi_context" = {
 *              "summary" = "Deletes by ID one product",
 *              "description" = "Operation restricted to managers."
 *          }
 *      }
 *  },
 *  collectionOperations = {
 *      "get" = {
 *          "normalization_context" = {
 *              "groups" = {"products:read"}
 *          },
 *          "openapi_context" = {
 *              "summary" = "Displays products list with filters",
 *              "description" = "Query to display all Bilemo products"
 *           }
 *      },
 *      "post" = {
 *          "controller" = NewProductMailer::class,
 *          "security" = "is_granted('ROLE_SUPER_ADMIN')",
 *          "security_message" = "Operation restricted to managers",
 *          "denormalization_context" = {
 *              "groups" = {"products:write"}
 *          },
 *          "openapi_context" = {
 *              "summary" = "Creates a new product",
 *              "description" = "Operation restricted to managers."
 *          }
 *      }
 *  }
 * ),
 * @ApiFilter(
 *  SearchFilter::class, 
 *  properties = {
 *      "phone":"partial",
 *      "trademark":"partial",
 *      "summary":"partial",
 *      "color":"partial"
 *  }
 * ),
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
     * @Groups({"product_details:read", "products:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80, unique=true)
     * 
     * @Assert\NotBlank
     * 
     * @Assert\Length(
     *  min="3",
     *  max="80",
     *  minMessage="Phone name : minimum 3 characters",
     *  maxMessage="Phone name : maximum 80 characters"
     * )
     * 
     * @Groups({"product_details:read", "products:read", "products:write"})
     * 
     * @ApiProperty(attributes={"openapi_context"={ "description"="MUST BE UNIQUE", "example"="Galaxy" }})
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=80)
     * 
     * @Assert\NotBlank
     * 
     * @Assert\Length(
     *  min="3",
     *  max="80",
     *  minMessage="Brand name : minimum 3 characters",
     *  maxMessage="Brand name : maximum 80 characters"
     * )
     * 
     * @Groups({"product_details:read", "products:read", "products:write"})
     * 
     * @ApiProperty(attributes={"openapi_context"={ "example"="Samsung" }})
     */
    private $trademark;

    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank
     * 
     * @Assert\Length(
     *  min="3",
     *  max="4000",
     *  minMessage="Phone description : minimum 3 characters",
     *  maxMessage="Phone description : maximum 4000 characters"
     * )
     * 
     * @Groups({"product_details:read", "products:read", "products:write"})
     */
    private $summary;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank
     * 
     * @Assert\Url(
     *      protocols = {"http", "https"}
     * )
     * 
     * @Groups({"product_details:read", "products:read", "products:write"})
     * 
     * @ApiProperty(attributes={"openapi_context"={ "description"="URL LINK", "example"="https://bilemo.com/galaxy.jpg" }})
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=40)
     * 
     * @Assert\NotBlank
     * 
     * @Assert\Length(
     *  min="3",
     *  max="40",
     *  minMessage="Phone color : minimum 3 characters",
     *  maxMessage="Phone color : maximum 40 characters"
     * )
     * 
     * @Groups({"product_details:read", "products:read", "products:write"})
     */
    private $color;

    /**
     * @ORM\Column(type="float")
     * 
     * @Assert\NotBlank
     * 
     * @Assert\Positive
     * 
     * @Assert\Type(
     *  type="float",
     *  message="Phone price must be a numeric value"
     * )
     * 
     * @Groups({"product_details:read", "products:read", "products:write"})
     * 
     * @ApiProperty(attributes={"openapi_context"={ "description"="MUST BE POSITIVE", "example"=799.99 }})
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"product_details:read", "products:read"})
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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
