<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Annotation\ApiProperty;

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
 *          "normalizationContext"={"groups"={"client_details_read"}},
 *          "access_control"="is_granted('ROLE_ADMIN')"
 *      },
 *      "put",
 *      "patch",
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
     * 
     * @ORM\GeneratedValue()
     * 
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"client_details_read", "client_read", "client_info"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=80)
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"client_details_read", "client_read"})
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=60)
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"client_details_read", "client_read"})
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=25)
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"client_details_read", "client_read"})
     */
    private $phoneNbr;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"client_details_read", "client_read"})
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Consumer", mappedBy="client", orphanRemoval=true)
     * 
     * @ApiSubresource()
     */
    private $consumers;

    public function __construct()
    {
        $this->consumers = new ArrayCollection();
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
     * @return Collection|Consumer[]
     */
    public function getConsumers(): Collection
    {
        return $this->consumers;
    }

    public function addConsumer(Consumer $consumer): self
    {
        if (!$this->consumers->contains($consumer)) {
            $this->consumers[] = $consumer;
            $consumer->setClient($this);
        }

        return $this;
    }

    public function removeConsumer(Consumer $consumer): self
    {
        if ($this->consumers->removeElement($consumer)) {
            // set the owning side to null (unless already changed)
            if ($consumer->getClient() === $this) {
                $consumer->setClient(null);
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
