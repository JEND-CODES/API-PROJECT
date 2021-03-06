<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use App\Controller\Operations\NewConsumerRole;
use App\Controller\Operations\ConsumerAccount;

/**
 * @ApiResource(
 *  attributes = {
 *      "order" = {"id":"DESC"}
 *  },
 *  paginationItemsPerPage = 2,
 *  itemOperations = {
 *      "get" = {
 *          "security" = "is_granted('ROLE_ADMIN')",
 *          "security_message" = "Resource restricted to administrators",
 *          "normalization_context" = {
 *              "groups" = {"consumers:read"}
 *          },
 *          "openapi_context" = {
 *              "summary" = "Displays the details of a consumer linked to a client",
 *              "description" = "Resource restricted to administrators."
 *          }
 *      },
 *      "delete" = {
 *          "security" = "is_granted('ROLE_ADMIN')",
 *          "security_message" = "Operation restricted to administrators",
 *          "openapi_context" = {
 *              "summary" = "Deletes by ID one consumer",
 *              "description" = "Operation restricted to administrators."
 *          }
 *      }
 *  },
 *  collectionOperations = {
 *      "get" = {
 *          "security" = "is_granted('ROLE_ADMIN')",
 *          "security_message" = "Collection restricted to administrators",
 *          "normalization_context" = {
 *              "groups" = {"consumers:read"}
 *          },
 *          "openapi_context" = {
 *              "summary" = "Displays the list of all consumers with filters",
 *              "description" = "Collection restricted to administrators."
 *          }
 *      },
 *      "post" = {
 *          "security" = "is_granted('ROLE_ADMIN')",
 *          "security_message" = "Operation restricted to administrators",
 *          "controller" = NewConsumerRole::class,
 *          "path" = "/my-consumers",
 *          "denormalization_context" = {
 *              "groups" = {"consumers:write"}
 *          },
 *          "openapi_context" = {
 *              "summary" = "Creates a new consumer with your client reference",
 *              "description" = "Operation restricted to administrators."
 *          }
 *      }, 
 *      "manager_post_consumer" = {
 *          "security" = "is_granted('ROLE_SUPER_ADMIN')",
 *          "security_message" = "Operation restricted to managers",
 *          "method" = "POST",
 *          "denormalization_context" = {
 *              "groups" = {"manager_consumers:write"}
 *          },
 *          "openapi_context" = {
 *              "summary" = "Creates a new consumer linked to a client",
 *              "description" = "Operation restricted to managers. Defines role and client reference."
 *          }
 *      }, 
 *      "consumer_account" = {
 *          "method" = "GET",
 *          "path" = "/account",
 *          "controller" = ConsumerAccount::class,
 *          "read" = false,
 *          "pagination_enabled" = false,
 *          "filters" = {},
 *          "normalization_context" = {
 *              "groups" = {"consumers:read"}
 *          },
 *          "openapi_context" = {
 *              "summary" = "Current user account information",
 *              "description" = "Displays current user account information",
 *              "tags" = {"Account"}
 *          }
 *      }
 *  }
 * ),
 * @ApiFilter(
 *  SearchFilter::class, 
 *  properties = {
 *      "username":"partial",
 *      "client.name":"partial"
 *  }
 * ),
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
     * @Groups({"consumers:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * 
     * @Assert\NotBlank
     * 
     * @Assert\Length(
     *  min="3",
     *  max="100",
     *  minMessage="Consumer username : minimum 3 characters",
     *  maxMessage="Consumer username : maximum 100 characters"
     * )
     * 
     * @Groups({"consumers:read", "consumers:write", "manager_consumers:write"})
     * 
     * @ApiProperty(attributes={"openapi_context"={ "description"="MUST BE UNIQUE" }})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * 
     * @Assert\NotBlank
     * 
     * @Assert\Email
     * 
     * @Groups({"consumers:read", "consumers:write", "manager_consumers:write"})
     * 
     * @ApiProperty(attributes={"openapi_context"={ "description"="MUST BE UNIQUE" }})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=80)
     * 
     * @Assert\NotBlank
     * 
     * @Assert\Length(
     *  min="3",
     *  max="80",
     *  minMessage="Consumer address : minimum 3 characters",
     *  maxMessage="Consumer address : maximum 80 characters"
     * )
     * 
     * @Groups({"consumers:read", "consumers:write", "manager_consumers:write"})
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=60)
     * 
     * @Assert\NotBlank
     * 
     * @Assert\Length(
     *  min="3",
     *  max="60",
     *  minMessage="Consumer city : minimum 3 characters",
     *  maxMessage="Consumer city : maximum 60 characters"
     * )
     * 
     * @Groups({"consumers:read", "consumers:write", "manager_consumers:write"})
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=25)
     * 
     * @Assert\NotBlank
     * 
     * @Assert\Length(
     *  min="3",
     *  max="25",
     *  minMessage="Consumer phone number : minimum 3 characters",
     *  maxMessage="Consumer phone number : maximum 25 characters"
     * )
     * 
     * @Groups({"consumers:read", "consumers:write", "manager_consumers:write"})
     */
    private $phoneNbr;

    /**
     * @ORM\Column(type="string")
     * 
     * @Assert\NotBlank
     * 
     * @Assert\Length(
     *  min="5",
     *  max="100",
     *  minMessage="Consumer password : minimum 3 characters",
     *  maxMessage="Consumer password : maximum 100 characters"
     * )
     * 
     * @Groups({"consumers:write", "manager_consumers:write"})
     * 
     * @ApiProperty(attributes={"openapi_context"={ "description"="WILL BE ENCODED" }})
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"consumers:read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=80)
     * 
     * @Groups({"consumers:read", "manager_consumers:write"})
     * 
     * @ApiProperty(attributes={"openapi_context"={ "description"="ROLE_USER, ROLE_ADMIN or ROLE_SUPER_ADMIN", "example"="ROLE_USER" }})
     */
    private $role;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="consumers")
     * 
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Groups({"consumers:read", "manager_consumers:write"})
     * 
     * @ApiProperty(attributes={"openapi_context"={ "example"="/api/clients/1" }})
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
