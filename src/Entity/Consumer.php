<?php

// Consulter la liste des utilisateurs inscrits liés à un client sur le site web : GET /api/clients/{id}/consumers -> "groups"={"clients_consumers"} ou GET /api/clients
// Consulter le détail d’un utilisateur inscrit lié à un client : GET /api/consumers/{id} ou GET /api/clients/{id}/consumers/{consumers}
// Ajouter un nouvel utilisateur lié à un client : POST /api/consumers
// Supprimer un utilisateur ajouté par un client : DELETE /api/consumers/{id}

// NOTE ! ON NE DEMANDE PAS DE PUT OU DE PATCH POUR UN UTILISATEUR LIÉ À CLIENT ?? SEULEMENT AJOUTER OU SUPPRIMER ??

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
// use Symfony\Component\Serializer\Annotation\MaxDepth;

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
 *         "normalization_context"={
 *         "groups"={"read", "client_info"}},
 *         "openapi_context" = {
 * 				"summary" = "Consult the details of a consumer linked to a client",
 *              "description" = "Query by identifier to consult consumer's informations"
 *          }
 *      },
 *      "put",
 *      "patch",
 *      "delete"
 *  },
 *  collectionOperations={
 *      "get",
 *      "post",
 *      "api_clients_consumers_get_subresource"={
 *          "normalization_context"={
 *               "groups"={"clients_consumers"}
 *          },
 *          "openapi_context" = {
 * 				"summary" = "Consult the list of consumers linked to a client",
 *              "description" = "Query by client ID to display the list of consumers"
 *          }
 *      }
 *  },
 *  normalizationContext={
 *      "groups"={"read"}
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
     * @Groups({"read", "clients_consumers"})
     * 
     * @ApiSubresource()
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"read", "clients_consumers"})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * 
     * @Assert\NotBlank
     * 
     * @Assert\Email
     * 
     * @Groups({"read", "clients_consumers"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=80)
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"read", "clients_consumers"})
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=60)
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"read", "clients_consumers"})
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=25)
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"read", "clients_consumers"})
     */
    private $phoneNbr;

    /**
     * @ORM\Column(type="string")
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"read", "clients_consumers"})
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"read", "clients_consumers"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=80)
     * 
     * @Groups({"read", "clients_consumers"})
     */
    private $role;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="consumers")
     * 
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Groups({"read"})
     */
    private $client;

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
