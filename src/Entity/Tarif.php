<?php

namespace App\Entity;

use App\Repository\TarifRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass=TarifRepository::class)
 * @ORM\HasLifecycleCallbacks()
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
     * @Assert\Positive
     */
    private $ageMin;

    /**
     * @Assert\Callback
    */
    public function validateAgeRange(ExecutionContextInterface $context)
    {
        if($this->ageMax && $this->ageMin >= $this->ageMax){
            $context->buildViolation('L\'âge maximum doit être supérieur à l\'âge minimum.')
            ->atPath('ageMax')
            ->addViolation();
        }
    }
    
    /**
     * @ORM\Column(type="integer", options={"unsigned"=true}, nullable=true)
     * @Assert\Positive
     * @Assert\LessThan(120)
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

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(message="Champ requis.")
     */
    private $name;

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

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAt(): self
    {
        $this->createdAt = new DateTimeImmutable();

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAt(): self
    {
        $this->updatedAt = new DateTimeImmutable();

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
