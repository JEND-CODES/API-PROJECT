<?php

// INSTALLATIONS DU PROJET ! 
// 1. Api Platform : composer require api
// 2. Bundle d'authentification : composer require lexik/jwt-authentication-bundle
// 3. Faker PHP pour les fixtures : composer require fakerphp/faker

// Docs Api Platform : https://api-platform.com/
// Docs JWT authentication : https://jwt.io/introduction
// Tuto Authentification JWT pour Api Symfony :
// https://www.whatzeweb.com/cours/creer-une-api-rest-avec-symfony/lauthentification-avec-jwt
// https://api-platform.com/docs/core/jwt/

// Voir ici la signification de GET, POST, PUT, PATCH & DELETE : https://api-platform.com/docs/core/operations/
// GET -> Affichage d'un ou plusieurs items
// POST -> Création d'un item
// PUT -> Remplacement d'un item
// PATCH -> Modification partielle d'un item
// DELETE -> Suppression d'un item


// COMMANDES DOCTRINE !
// 0. Création BDD : php bin/console doctrine:database:create
// 1. Créer un Controller -> php bin/console make:controller
// 2. Si la BDD a déjà été créée -> Créer une nouvelle Entity : php bin/console make:entity
// 3. Renseigner les colonnes voulues pour la table SQL et faire une migration -> php bin/console make:migration (le nouveau fichier Entity est alors mis à jour)
// 4. Pour actualiser la BDD avec la nouvelle table souhaitée, faire ensuite -> php bin/console doctrine:migrations:migrate

// Mettre à jour la BDD :
// 1 -> php bin/console make:migration
// 2 -> php bin/console doctrine:migrations:migrate

// Utiliser le terminal de commande pour mettre à jour une Entité : après avoir indiqué par exemple "private $truc" avec son annotation, il suffit de faire un coup de  "php bin/console make:entity --regenerate App" et les getters/setters sont générés !

// Pour mettre ensuite à jour la BDD faire un "php bin/console doctrine:schema:update --dump-sql" puis "php bin/console doctrine:schema:update --force"

// Pour vérifier si les Entités sont conformes, qu'il n'y a notamment pas de problèmes de mappings entre Entités, faire : "php bin/console doctrine:schema:validate"

// CLEAR THE CACHE ! "php bin/console cache:clear"

// LANCER LE LIVE ! php -S localhost:4000 -t public
// http://localhost:4000/api

// FIXTURES ! php bin/console doctrine:fixtures:load

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
