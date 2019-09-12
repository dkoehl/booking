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
        $this->price = $price;

        return $this;
    }
}
