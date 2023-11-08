<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"users"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Champ requis.")
     * @Assert\Regex(
     *      pattern="/^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$/", 
     *      message="Le mot de passe ne répond pas aux critères"
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=8, unique=true)
     * @Groups({"users"})
     * @Assert\Regex(
     *     pattern="/^\d{7}[A-Z]$/",
     *     message="Le numéro de licence doit contenir 7 chiffres suivis d'une lettre majuscule."
     * )
     */
    private $licenceNumber;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"users"})
     * @Assert\NotBlank(message="Champ requis.")
     * @Assert\Regex(
     *      pattern="/^[\p{L}\-]+$/u",
     *      match=true,
     *      message="Votre nom ne peut contenir que des lettres et des tirets."
     * )
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"users"})
     * @Assert\NotBlank(message="Champ requis.")
     * @Assert\Regex(
     *      pattern="/^[A-Za-z\-]+$/",
     *      match=true,
     *      message="Votre nom ne peut contenir que des lettres et des tirets."
     * )
     */
    private $lastname;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Assert\NotBlank(message="Champ requis.")
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="boolean", options={"default":"0"})
     */
    private $subscription;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Groups({"users"})
     */
    private $position;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;


    /**
     * @ORM\ManyToMany(targetEntity=Course::class, inversedBy="users", orphanRemoval=true)
     */
    private $courses;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
    }

    /**
     * @Assert\Callback
     */
    public function validateRoles(ExecutionContextInterface $context)
    {
        $allowedRoles = ["ROLE_ADMIN", "ROLE_USER"];

        if (!is_array($this->roles)) {
            //  If the "roles" field is not an array, generate a violation.
            $context->buildViolation('Le champ "roles" doit être un tableau.')->atPath('roles')->addViolation();
        } elseif (count($this->roles) !== 1 || !in_array($this->roles[0], $allowedRoles)) {
            // If the array contains more than one role or if the role is not allowed, generate a violation.
            $context->buildViolation('Vous devez choisir exactement un rôle parmi "Administrateur" et "Licencié".')->atPath('roles')->addViolation();
        }
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAt()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new DateTimeImmutable();
    }
 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        // $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLicenceNumber(): ?string
    {
        return $this->licenceNumber;
    }

    public function setLicenceNumber(string $licenceNumber): self
    {
        $this->licenceNumber = $licenceNumber;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeImmutable
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeImmutable $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function isSubscription(): ?bool
    {
        return $this->subscription;
    }

    public function setSubscription(bool $subscription): self
    {
        $this->subscription = $subscription;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    
    /**
     * @return Collection<int, Course>
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses[] = $course;
        }

        return $this;
    }

  

    public function removeCourse(Course $course): self
    {
        $this->courses->removeElement($course);

        return $this;
    }


}
