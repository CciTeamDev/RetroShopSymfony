<?php

namespace App\Entity;

use App\Repository\PurchaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PurchaseRepository::class)
 */
class Purchase
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="float")
     */
    private $total;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $id_stripe;

    

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="user")
     * @ORM\JoinColumn(nullable=false)
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=PurchaseHaveProduct::class, mappedBy="purchase", cascade={"remove"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $purchaseCommande;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $carrierName;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $carrierPrice;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $delivery;

    public function __construct()
    {
        $this->purchaseCommande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getIdStripe(): ?string
    {
        return $this->id_stripe;
    }

    public function setIdStripe(?string $id_stripe): self
    {
        $this->id_stripe = $id_stripe;

        return $this;
    }


    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|PurchaseHaveProduct[]
     */
    public function getPurchaseCommande(): Collection
    {
        return $this->purchaseCommande;
    }

    public function addPurchaseCommande(PurchaseHaveProduct $purchaseCommande): self
    {
        if (!$this->purchaseCommande->contains($purchaseCommande)) {
            $this->purchaseCommande[] = $purchaseCommande;
            $purchaseCommande->setPurchase($this);
        }

        return $this;
    }

    public function removePurchaseCommande(PurchaseHaveProduct $purchaseCommande): self
    {
        if ($this->purchaseCommande->removeElement($purchaseCommande)) {
            // set the owning side to null (unless already changed)
            if ($purchaseCommande->getPurchase() === $this) {
                $purchaseCommande->setPurchase(null);
            }
        }

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getCarrierName(): ?string
    {
        return $this->carrierName;
    }

    public function setCarrierName(string $carrierName): self
    {
        $this->carrierName = $carrierName;

        return $this;
    }

    public function getCarrierPrice(): ?float
    {
        return $this->carrierPrice;
    }

    public function setCarrierPrice(?float $carrierPrice): self
    {
        $this->carrierPrice = $carrierPrice;

        return $this;
    }

    public function getDelivery(): ?string
    {
        return $this->delivery;
    }

    public function setDelivery(?string $delivery): self
    {
        $this->delivery = $delivery;

        return $this;
    }
}
