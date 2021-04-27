<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ApiResource(
 *  attributes={
 *      "order"={"id":"DESC"},
 *      "security"="is_granted('ROLE_ADMIN')",
 *      "security_message"="Resources and operations reserved for administrators"
 *  },
 *  paginationItemsPerPage=2,
 *  itemOperations={
 *      "get"={
 *          "normalization_context"={
 *              "groups"={"consumer_details:read"}
 *          },
 *          "openapi_context" = {
 *              "summary" = "Consult the details of a consumer linked to a client",
 *              "description" = "Query by identifier to consult consumer's informations", 
 *              "tags" = {"SINGLE CONSUMER"}
 *          }
 *      },
 *      "delete"={
 *          "openapi_context" = {
 *              "summary" = "Delete one consumer",
 *              "description" = "Delete by ID one consumer", 
 *              "tags" = {"REMOVE CONSUMER"}
 *          }
 *      }
 *  },
 *  collectionOperations={
 *      "get"={
 *          "normalization_context"={
 *              "groups"={"consumers:read"}
 *          },
 *          "openapi_context" = {
 *              "summary" = "Query to the list of consumers",
 *              "description" = "Displays the list of every consumers",
 *              "tags" = {"ALL CONSUMERS"}
 *          }
 *      },
 *      "post"={
 *          "denormalization_context"={
 *              "groups"={"consumers:write"}
 *          },
 *          "openapi_context" = {
 *              "summary" = "Creates a new consumer linked to a client",
 *              "description" = "The new consumer will receive an email",
 *              "tags" = {"ADD CONSUMER"}
 *          }
 *      }
 *  }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ConsumerRepository")
 */
class Consumer implements UserInterface
{

    /**
     * @ORM\Id()
     * 
     * @ORM\GeneratedValue()
     * 
     * @ORM\Column(type="integer")
     * 
     * @Groups({"consumer_details:read", "consumers:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"consumer_details:read", "consumers:read", "consumers:write"})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * 
     * @Assert\NotBlank
     * 
     * @Assert\Email
     * 
     * @Groups({"consumer_details:read", "consumers:write"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=80)
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"consumer_details:read", "consumers:write"})
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=60)
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"consumer_details:read", "consumers:write"})
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=25)
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"consumer_details:read", "consumers:write"})
     */
    private $phoneNbr;

    /**
     * @ORM\Column(type="string")
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"consumers:write"})
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"consumer_details:read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=80)
     * 
     * @Groups({"consumer_details:read", "consumers:write"})
     */
    private $role;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="consumers")
     * 
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Groups({"consumer_details:read", "consumers:write"})
     */
    private $client;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

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

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function eraseCredentials() {}
    
    public function getSalt() {}
    
    public function getRoles() 
    {
        return [$this->getRole()];
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPhoneNbr(): ?string
    {
        return $this->phoneNbr;
    }

    public function setPhoneNbr(string $phoneNbr): self
    {
        $this->phoneNbr = $phoneNbr;

        return $this;
    }

}
