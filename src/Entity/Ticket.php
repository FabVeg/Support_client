<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Service;
use App\Entity\Customer;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TicketRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=TicketRepository::class)
 */
class Ticket
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer") @ORM\JoinColumn(nullable=false)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255) @ORM\JoinColumn(nullable=false)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255) @ORM\JoinColumn(nullable=false)
     * 
     */
    private $priority;

    /**
     * @ORM\Column(type="string", length=255)
     *  @ORM\JoinColumn(nullable=false)
     */
    private $statut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_date;

    /**
     * @ORM\ManyToMany(targetEntity=Service::class, inversedBy="tickets")
     *  @ORM\JoinColumn(nullable=false)
     */
    private $service;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tickets")
     */
    private $auteur;

    /**
     * @ORM\Column(type="string", length=255)
     *  @ORM\JoinColumn(nullable=false)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="tickets")
     */
    private $customer;

    public function __construct()
    {
        $this->service = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getpriority(): ?string
    {
        return $this->priority;
    }

    public function setpriority(string $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->created_date;
    }

    public function setCreatedDate(\DateTimeInterface $created_date): self
    {
        $this->created_date = $created_date;

        return $this;
    }

    /**
    * toString
    * @return string
    */
    public function __toString(){
        return (string) $this->name;
    }

    /**
     * @return Collection|Service[]
     */
    public function getService(): Collection
    {
        return $this->service;
    }

    public function addService(Service $service): self
    {
        if (!$this->Service->contains($service)) {
            $this->Service[] = $service;
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->Service->contains($service)) {
            $this->Service->removeElement($service);
        }

        return $this;
    }

    public function getAuteur(): ?User
    {
        return $this->auteur;
    }

    public function setAuteur(?User $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

}
