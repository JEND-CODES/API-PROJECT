<?php

// INSTALLATIONS DU PROJET ! 
// 1. Api Platform : composer require api
// 2. Bundle d'authentification : composer require lexik/jwt-authentication-bundle
// 3. Faker PHP pour les fixtures : composer require fakerphp/faker

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Serializer\Annotation\Groups;

// NOTE ! ON NE DEMANDE D'AFFICHER DANS L'API QU'UN SEUL CLIENT DE BILEMO !?
// NOTE ! ON NE DEMANDE PAS DE CRÉER, MODIFIER OU SUPPRIMER UN CLIENT ?

// 2 types d'opérations (itemOperations & collectionOperations) qui ciblent : 
// Soit des collections (ex: get -> /api/clients)
// Soit des items, des ressources spécifiques (ex: /api/clients/{id})

/**
 * @ApiResource(
 *  itemOperations={
 *      "get"={
 *          "normalizationContext"={"groups"={"client_details_read"}}
 *      },
 *      "put",
 *      "delete"
 *  }, 
 *  collectionOperations={
 *      "get"={
 *          "normalizationContext"={"groups"={"client_read"}}
 *      },
 *      "post"
 *  }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"client_details_read", "client_read"})
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Groups({"client_details_read", "client_read"})
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="client", orphanRemoval=true)
     * @ApiSubresource()
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setClient($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getClient() === $this) {
                $user->setClient(null);
            }
        }

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

    
}
