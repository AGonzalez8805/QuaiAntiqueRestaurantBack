<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $guestNumber = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $orderDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $orderHour = null;

    #[ORM\Column(length: 255)]
    private ?string $allergy = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updateAt = null;

    // --- ManyToMany relation avec Restaurant ---
    #[ORM\ManyToMany(targetEntity: Restaurant::class, inversedBy: "bookings")]
    #[ORM\JoinTable(name: "booking_restaurant")]
    private Collection $restaurants;

    // --- ManyToOne relation avec User (client) ---
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $client = null;

    public function __construct()
    {
        $this->restaurants = new ArrayCollection();
    }

    // --- Getters et setters ---
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGuestNumber(): ?int
    {
        return $this->guestNumber;
    }

    public function setGuestNumber(int $guestNumber): static
    {
        $this->guestNumber = $guestNumber;
        return $this;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(\DateTimeInterface $orderDate): static
    {
        $this->orderDate = $orderDate;
        return $this;
    }

    public function getOrderHour(): ?\DateTimeInterface
    {
        return $this->orderHour;
    }

    public function setOrderHour(\DateTimeInterface $orderHour): static
    {
        $this->orderHour = $orderHour;
        return $this;
    }

    public function getAllergy(): ?string
    {
        return $this->allergy;
    }

    public function setAllergy(string $allergy): static
    {
        $this->allergy = $allergy;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeImmutable $updateAt): static
    {
        $this->updateAt = $updateAt;
        return $this;
    }

    public function getRestaurants(): Collection
    {
        return $this->restaurants;
    }

    public function addRestaurant(Restaurant $restaurant): static
    {
        if (!$this->restaurants->contains($restaurant)) {
            $this->restaurants->add($restaurant);
        }
        return $this;
    }

    public function removeRestaurant(Restaurant $restaurant): static
    {
        $this->restaurants->removeElement($restaurant);
        return $this;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): static
    {
        $this->client = $client;
        return $this;
    }
}
