<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use App\Controller\Operations\NewClientAddConsumer;

/**
 * @ApiResource(
 *  attributes = {
 *      "order" = {"id":"DESC"}
 *  },
 *  paginationItemsPerPage = 2,
 *  itemOperations = {
 *      "get" = {
 *          "normalizationContext" = {
 *              "groups" = {"clients:read"}
 *          }, 
 *          "openapi_context" = {
 *              "summary" = "Single client information with the list of linked consumers",
 *              "description" = "Query by client ID to display client information."
 *           }
 *      },
 *      "delete" = {
 *          "security" = "is_granted('ROLE_SUPER_ADMIN')",
 *          "security_message" = "Operation restricted to managers",
 *          "openapi_context" = {
 *              "summary" = "Deletes by ID one client",
 *              "description" = "Operation restricted to managers."
 *          }
 *      }
 *  }, 
 *  collectionOperations = {
 *      "get" = {
 *          "normalizationContext" = {
 *              "groups" = {"clients:read"}
 *          }, 
 *          "openapi_context" = {
 *              "summary" = "Query to the list of clients",
 *              "description" = "Displays the list of Bilemo clients."
 *           }
 *      },
 *      "post" = {
 *          "security" = "is_granted('ROLE_SUPER_ADMIN')",
 *          "security_message" = "Operation restricted to managers",
 *          "controller" = NewClientAddConsumer::class,
 *          "denormalization_context" = {
 *              "groups" = {"clients:write"}
 *          },
 *          "openapi_context" = {
 *              "summary" = "Creates a new client",
 *              "description" = "Operation restricted to managers."
 *          }
 *      }
 *  }
 * ),
 * @ApiFilter(
 *  SearchFilter::class, 
 *  properties = {
 *      "name":"partial"
 *  }
 * ),
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
     * 
     * @Groups({"clients:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * 
     * @Assert\NotBlank
     * 
     * @Assert\Length(
     *  min="3",
     *  max="60",
     *  minMessage="Client name : minimum 3 characters",
     *  maxMessage="Client name : maximum 60 characters"
     * )
     * 
     * @Groups({"clients:read", "consumer_details:read", "clients:write"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=80)
     * 
     * @Assert\NotBlank
     * 
     * @Assert\Length(
     *  min="3",
     *  max="80",
     *  minMessage="Client address : minimum 3 characters",
     *  maxMessage="Client address : maximum 80 characters"
     * )
     * 
     * @Groups({"clients:read", "clients:write"})
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
     *  minMessage="Client city : minimum 3 characters",
     *  maxMessage="Client city : maximum 60 characters"
     * )
     * 
     * @Groups({"clients:read", "clients:write"})
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
     *  minMessage="Client phone number : minimum 3 characters",
     *  maxMessage="Client phone number : maximum 25 characters"
     * )
     * 
     * @Groups({"clients:read", "clients:write"})
     */
    private $phoneNbr;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Assert\NotBlank
     * 
     * @Groups({"clients:read"})
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Consumer", mappedBy="client", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $consumers;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
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
