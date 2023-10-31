<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order extends EntityAbstract
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $sourceId = null;

    #[ORM\Column]
    private ?int $destId = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?Customer $customer = null;

    #[ORM\Column(nullable: true)]
    private ?float $total = null;

    #[ORM\OneToMany(mappedBy: 'orderEntity', targetEntity: OrderItem::class, orphanRemoval: true)]
    private Collection $items;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSourceId(): ?int
    {
        return $this->sourceId;
    }

    public function setSourceId(int $sourceId): static
    {
        $this->sourceId = $sourceId;

        return $this;
    }

    public function getDestId(): ?int
    {
        return $this->destId;
    }

    public function setDestId(int $destId): static
    {
        $this->destId = $destId;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): static
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(OrderItem $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setOrderEntity($this);
        }

        return $this;
    }

    public function removeItem(OrderItem $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getOrderEntity() === $this) {
                $item->setOrderEntity(null);
            }
        }

        return $this;
    }
}
