<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InventoryRepository")
 */
class Inventory
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
    private $beds;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $closets;

    /**
     * @ORM\Column(type="integer")
     */
    private $tables;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $chairs;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $floor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $walls;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $windows;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $doors;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $roomsspecial;

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
     * @ORM\Column(type="text", nullable=true)
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Booking", inversedBy="inventories")
     */
    private $inventory;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBeds(): ?int
    {
        return $this->beds;
    }

    public function setBeds(?int $beds): self
    {
        $this->beds = $beds;

        return $this;
    }

    public function getClosets(): ?int
    {
        return $this->closets;
    }

    public function setClosets(?int $closets): self
    {
        $this->closets = $closets;

        return $this;
    }

    public function getTables(): ?int
    {
        return $this->tables;
    }

    public function setTables(int $tables): self
    {
        $this->tables = $tables;

        return $this;
    }

    public function getChairs(): ?int
    {
        return $this->chairs;
    }

    public function setChairs(?int $chairs): self
    {
        $this->chairs = $chairs;

        return $this;
    }

    public function getFloor(): ?string
    {
        return $this->floor;
    }

    public function setFloor(?string $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getWalls(): ?string
    {
        return $this->walls;
    }

    public function setWalls(?string $walls): self
    {
        $this->walls = $walls;

        return $this;
    }

    public function getWindows(): ?int
    {
        return $this->windows;
    }

    public function setWindows(?int $windows): self
    {
        $this->windows = $windows;

        return $this;
    }

    public function getDoors(): ?string
    {
        return $this->doors;
    }

    public function setDoors(?string $doors): self
    {
        $this->doors = $doors;

        return $this;
    }

    public function getRoomsspecial(): ?string
    {
        return $this->roomsspecial;
    }

    public function setRoomsspecial(?string $roomsspecial): self
    {
        $this->roomsspecial = $roomsspecial;

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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getInventory(): ?Booking
    {
        return $this->inventory;
    }

    public function setInventory(?Booking $inventory): self
    {
        $this->inventory = $inventory;

        return $this;
    }
}
