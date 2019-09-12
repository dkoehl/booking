<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParkingRepository")
 */
class Parking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $carplate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $startdate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $enddate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $hidden;

    /**
     * @ORM\Column(type="integer", nullable=true)
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarplate(): ?string
    {
        return $this->carplate;
    }

    public function setCarplate(?string $carplate): self
    {
        $this->carplate = $carplate;

        return $this;
    }

    public function getStartdate(): ?\DateTimeInterface
    {
        return $this->startdate;
    }

    public function setStartdate(?\DateTimeInterface $startdate): self
    {
        $this->startdate = $startdate;

        return $this;
    }

    public function getEnddate(): ?\DateTimeInterface
    {
        return $this->enddate;
    }

    public function setEnddate(?\DateTimeInterface $enddate): self
    {
        $this->enddate = $enddate;

        return $this;
    }

    public function getHidden(): ?int
    {
        return $this->hidden;
    }

    public function setHidden(?int $hidden): self
    {
        $this->hidden = $hidden;

        return $this;
    }

    public function getDeleted(): ?int
    {
        return $this->deleted;
    }

    public function setDeleted(?int $deleted): self
    {
        $this->deleted = $deleted;

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
