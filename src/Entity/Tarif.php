<?php

namespace App\Entity;

use App\Repository\TarifRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TarifRepository::class)
 */
class Tarif
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    private $ageMin;

    /**
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    private $ageMax;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2, options={"unsigned"=true})
     */
    private $amount;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2, options={"unsigned"=true})
     */
    private $gearAmount;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAgeMin(): ?int
    {
        return $this->ageMin;
    }

    public function setAgeMin(int $ageMin): self
    {
        $this->ageMin = $ageMin;

        return $this;
    }

    public function getAgeMax(): ?int
    {
        return $this->ageMax;
    }

    public function setAgeMax(int $ageMax): self
    {
        $this->ageMax = $ageMax;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getGearAmount(): ?string
    {
        return $this->gearAmount;
    }

    public function setGearAmount(string $gearAmount): self
    {
        $this->gearAmount = $gearAmount;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
