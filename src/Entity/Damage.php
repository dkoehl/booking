<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DamageRepository")
 */
class Damage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $damageart;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $damagetext;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $hidden;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $deleted;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $crdate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tstamp;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Booking", inversedBy="damages")
     */
    private $damage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Booking", inversedBy="damage")
     */
    private $booking;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDamageart(): ?string
    {
        return $this->damageart;
    }

    public function setDamageart(string $damageart): self
    {
        $this->damageart = $damageart;

        return $this;
    }

    public function getDamagetext(): ?string
    {
        return $this->damagetext;
    }

    public function setDamagetext(?string $damagetext): self
    {
        $this->damagetext = $damagetext;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = str_replace(',', '.', $price);

        return $this;
    }

    public function getDamage(): ?Booking
    {
        return $this->damage;
    }

    public function setDamage(?Booking $damage): self
    {
        $this->damage = $damage;

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

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(?bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getBooking(): ?Booking
    {
        return $this->booking;
    }

    public function setBooking(?Booking $booking): self
    {
        $this->booking = $booking;

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

}
