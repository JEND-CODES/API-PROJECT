<?php

// Consulter la liste des utilisateurs inscrits liés à un client sur le site web : GET /api/clients/{id}/users -> "groups"={"clients_users"}
// Consulter le détail d’un utilisateur inscrit lié à un client : GET /api/users/{id} ou GET /api/clients/{id}/users/{users}
// Ajouter un nouvel utilisateur lié à un client : POST /api/users
// Supprimer un utilisateur ajouté par un client : DELETE /api/users/{id}

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
 *  itemOperations={
 *      "get",
 *      "put",
 *      "patch",
 *      "delete"
 *  },
 *  collectionOperations={
 *      "post",
 *      "api_clients_users_get_subresource"={
 *          "normalization_context"={
 *               "groups"={"clients_users"}
 *          }
 *      }
 *  },
 *  normalizationContext={
 *      "groups"={"read"}
 *  }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read", "clients_users"})
     * @ApiSubresource()
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\NotBlank
     * @Groups({"read", "clients_users"})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank
     * @Assert\Email
     * @Groups({"read", "clients_users"})
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Groups({"read", "clients_users"})
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Groups({"read", "clients_users"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read", "clients_users"})
     */
    private $role;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
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

}
