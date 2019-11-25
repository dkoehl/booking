<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 */
class Booking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $bookingfrom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $bookingtill;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $deleted;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $hidden;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $crdate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tstamp;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Room", mappedBy="booking")
     */
    private $room;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Room", inversedBy="bookings")
     */
    private $bookedroom;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Guest", inversedBy="bookings")
     */
    private $guest;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Inventory", mappedBy="inventory")
     */
    private $inventories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Parking", mappedBy="parking")
     */
    private $parkings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Payment", mappedBy="payments")
     */
    private $payments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Damage", mappedBy="damage")
     */
    private $damages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Price", mappedBy="prices")
     */
    private $prices;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Price", mappedBy="booking")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Damage", mappedBy="booking")
     */
    private $damage;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Inventory", mappedBy="booking")
     */
    private $inventory;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Parking", mappedBy="booking")
     */
    private $parking;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Payment", mappedBy="booking")
     */
    private $payment;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Occupancy", mappedBy="occupancies")
     */
    private $occupancies;

    public function __construct()
    {
        $this->room = new ArrayCollection();
        $this->inventories = new ArrayCollection();
        $this->parkings = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->damages = new ArrayCollection();
        $this->prices = new ArrayCollection();
        $this->price = new ArrayCollection();
        $this->damage = new ArrayCollection();
        $this->inventory = new ArrayCollection();
        $this->parking = new ArrayCollection();
        $this->payment = new ArrayCollection();
        $this->occupancies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookingfrom(): ?\DateTimeInterface
    {
        return $this->bookingfrom;
    }

    public function setBookingfrom(\DateTimeInterface $bookingfrom): self
    {
        $this->bookingfrom = $bookingfrom;

        return $this;
    }

    public function getBookingtill(): ?\DateTimeInterface
    {
        return $this->bookingtill;
    }

    public function setBookingtill(\DateTimeInterface $bookingtill): self
    {
        $this->bookingtill = $bookingtill;

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(?bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getHidden(): ?bool
    {
        return $this->hidden;
    }

    public function setHidden(?bool $hidden): self
    {
        $this->hidden = $hidden;

        return $this;
    }

    public function getCrdate(): ?int
    {
        return $this->crdate;
    }

    public function setCrdate(?int $crdate): self
    {
        $this->crdate = $crdate;

        return $this;
    }

    public function getTstamp(): ?int
    {
        return $this->tstamp;
    }

    public function setTstamp(?int $tstamp): self
    {
        $this->tstamp = $tstamp;

        return $this;
    }

    /**
     * @return Collection|Room[]
     */
    public function getRoom(): Collection
    {
        return $this->room;
    }

    public function addRoom($room): self
    {
        if (!$this->room->contains($room)) {
            $this->room = $room;
            $room->setBooking($this);
        }

        return $this;
    }

    public function removeRoom(Room $room): self
    {
        if ($this->room->contains($room)) {
            $this->room->removeElement($room);
            // set the owning side to null (unless already changed)
            if ($room->getBooking() === $this) {
                $room->setBooking(null);
            }
        }

        return $this;
    }

    public function getBookedroom(): ?Room
    {
        return $this->bookedroom;
    }

    public function setBookedroom(?Room $bookedroom): self
    {
        $this->bookedroom = $bookedroom;

        return $this;
    }

    public function getGuest(): ?Guest
    {
        return $this->guest;
    }

    public function setGuest(?Guest $guest): self
    {
        $this->guest = $guest;

        return $this;
    }

    /**
     * @return Collection|Inventory[]
     */
    public function getInventories(): Collection
    {
        return $this->inventories;
    }

    public function addInventory(Inventory $inventory): self
    {
        if (!$this->inventories->contains($inventory)) {
            $this->inventories[] = $inventory;
            $inventory->setInventory($this);
        }

        return $this;
    }

    public function removeInventory(Inventory $inventory): self
    {
        if ($this->inventories->contains($inventory)) {
            $this->inventories->removeElement($inventory);
            // set the owning side to null (unless already changed)
            if ($inventory->getInventory() === $this) {
                $inventory->setInventory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Parking[]
     */
    public function getParkings(): Collection
    {
        return $this->parkings;
    }

    public function addParking(Parking $parking): self
    {
        if (!$this->parkings->contains($parking)) {
            $this->parkings[] = $parking;
            $parking->setParking($this);
        }

        return $this;
    }

    public function removeParking(Parking $parking): self
    {
        if ($this->parkings->contains($parking)) {
            $this->parkings->removeElement($parking);
            // set the owning side to null (unless already changed)
            if ($parking->getParking() === $this) {
                $parking->setParking(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Payment[]
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): self
    {
        if (!$this->payments->contains($payment)) {
            $this->payments[] = $payment;
            $payment->setPayments($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): self
    {
        if ($this->payments->contains($payment)) {
            $this->payments->removeElement($payment);
            // set the owning side to null (unless already changed)
            if ($payment->getPayments() === $this) {
                $payment->setPayments(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Damage[]
     */
    public function getDamages(): Collection
    {
        return $this->damages;
    }

    public function addDamage(Damage $damage): self
    {
        if (!$this->damages->contains($damage)) {
            $this->damages[] = $damage;
            $damage->setDamage($this);
        }

        return $this;
    }

    public function removeDamage(Damage $damage): self
    {
        if ($this->damages->contains($damage)) {
            $this->damages->removeElement($damage);
            // set the owning side to null (unless already changed)
            if ($damage->getDamage() === $this) {
                $damage->setDamage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Price[]
     */
    public function getPrices(): Collection
    {
        return $this->prices;
    }

    public function addPrice(Price $price): self
    {
        if (!$this->prices->contains($price)) {
            $this->prices[] = $price;
            $price->setPrices($this);
        }

        return $this;
    }

    public function removePrice(Price $price): self
    {
        if ($this->prices->contains($price)) {
            $this->prices->removeElement($price);
            // set the owning side to null (unless already changed)
            if ($price->getPrices() === $this) {
                $price->setPrices(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Price[]
     */
    public function getPrice(): Collection
    {
        return $this->price;
    }
    
    public function setPrice(?Price $price): self
    {
        $this->price = $price;
        
        return $this;
    }

    /**
     * @return Collection|Damage[]
     */
    public function getDamage(): Collection
    {
        return $this->damage;
    }

    /**
     * @return Collection|Inventory[]
     */
    public function getInventory(): Collection
    {
        return $this->inventory;
    }

    /**
     * @return Collection|Parking[]
     */
    public function getParking(): Collection
    {
        return $this->parking;
    }
    public function setParking(?Payment $parking): self
    {
        $this->parking = $parking;
        
        return $this;
    }

    /**
     * @return Collection|Payment[]
     */
    public function getPayment(): Collection
    {
        return $this->payment;
    }
    
    public function setPayment(?Payment $payment): self
    {
        $this->payment = $payment;
        
        return $this;
    }

    /**
     * @return Collection|Occupancy[]
     */
    public function getOccupancies(): Collection
    {
        return $this->occupancies;
    }

    public function addOccupancy(Occupancy $occupancy): self
    {
        if (!$this->occupancies->contains($occupancy)) {
            $this->occupancies[] = $occupancy;
            $occupancy->setOccupancies($this);
        }

        return $this;
    }

    public function removeOccupancy(Occupancy $occupancy): self
    {
        if ($this->occupancies->contains($occupancy)) {
            $this->occupancies->removeElement($occupancy);
            // set the owning side to null (unless already changed)
            if ($occupancy->getOccupancies() === $this) {
                $occupancy->setOccupancies(null);
            }
        }

        return $this;
    }
}
