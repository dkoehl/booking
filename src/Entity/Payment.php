<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PaymentRepository")
 */
class Payment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $payment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $securitynumber;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Booking", inversedBy="payments")
     */
    private $payments;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPayment(): ?int
    {
        return $this->payment;
    }

    public function setPayment(?int $payment): self
    {
        $this->payment = $payment;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getSecuritynumber(): ?string
    {
        return $this->securitynumber;
    }

    public function setSecuritynumber(?string $securitynumber): self
    {
        $this->securitynumber = $securitynumber;

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

    public function getPayments(): ?Booking
    {
        return $this->payments;
    }

    public function setPayments(?Booking $payments): self
    {
        $this->payments = $payments;

        return $this;
    }
}
