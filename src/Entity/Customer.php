<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CustomerRepository;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

 
/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 * @UniqueEntity("name", message="Ce nom de société existe déjà !")
 */
class Customer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
 
    /**
     * @ORM\Column(type="string", length=120)
     */
    private $name;
 
    /**
     * @ORM\Column(type="string", length=14, nullable=true)
     */
    private $siret;
 
    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $address1;
 
    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $address2;
 
    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $city;
 
    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $zipCode;
 
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
 
    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="customer", cascade={"persist"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Ticket::class, mappedBy="customer")
     */
    private $tickets;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->tickets = new ArrayCollection();
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
 
    public function getSiret(): ?string
    {
        return $this->siret;
    }
 
    public function setSiret(?string $siret): self
    {
        $this->siret = $siret;
 
        return $this;
    }
 
    public function getaddress1(): ?string
    {
        return $this->address1;
    }
 
    public function setaddress1(?string $address1): self
    {
        $this->address1 = $address1;
 
        return $this;
    }
 
    public function getaddress2(): ?string
    {
        return $this->address2;
    }
 
    public function setaddress2(?string $address2): self
    {
        $this->address2 = $address2;
 
        return $this;
    }
 
    public function getCity(): ?string
    {
        return $this->city;
    }
 
    public function setCity(?string $city): self
    {
        $this->city = $city;
 
        return $this;
    }
 
    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }
 
    public function setZipCode(?string $zipCode): self
    {
        $this->zipCode = $zipCode;
 
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
 
    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }
 
    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setCustomer($this);
        }
 
        return $this;
    }
 
    public function removeUser(User $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getCustomer() === $this) {
                $user->setCustomer(null);
            }
        }
 
        return $this;
    }

    /**
     * @return Collection|Ticket[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setCustomer($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
            // set the owning side to null (unless already changed)
            if ($ticket->getCustomer() === $this) {
                $ticket->setCustomer(null);
            }
        }

        return $this;
    }

}
