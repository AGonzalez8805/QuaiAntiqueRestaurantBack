<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Menu;
use App\Entity\Booking;

#[ORM\Entity(repositoryClass: RestaurantRepository::class)]
class Restaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private array $amOpeningTime = [];

    #[ORM\Column]
    private array $pmOpeningTime = [];

    #[ORM\Column(type: Types::SMALLINT)]
    private int $maxGuest = 0;

    #[ORM\Column]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'restaurant', targetEntity: Picture::class, orphanRemoval: true)]
    private Collection $pictures;

    #[ORM\OneToMany(mappedBy: 'restaurant', targetEntity: Menu::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $menus;

    // --- ManyToMany relation avec Booking ---
    #[ORM\ManyToMany(mappedBy: 'restaurants', targetEntity: Booking::class)]
    private Collection $bookings;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->menus = new ArrayCollection();
        $this->bookings = new ArrayCollection();
    }

    // --- Getters/Setters pour les menus ---
    /** @return Collection<int, Menu> */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): static
    {
        if (!$this->menus->contains($menu)) {
            $this->menus->add($menu);
            $menu->setRestaurant($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): static
    {
        if ($this->menus->removeElement($menu) && $menu->getRestaurant() === $this) {
            $menu->setRestaurant(null);
        }

        return $this;
    }

    // --- Getters/Setters pour bookings ---
    /** @return Collection<int, Booking> */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): static
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->addRestaurant($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            $booking->removeRestaurant($this);
        }

        return $this;
    }
}
