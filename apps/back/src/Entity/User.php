<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeImmutable;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    private Uuid $uuid;

    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $email;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[Assert\PasswordStrength]
    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: "datetime_immutable")]
    private DateTimeImmutable $registerAt;
    #[ORM\Column(type: 'integer')]
    private int $videoViewed;
    #[ORM\Column(type: 'string')]
    private string $username;

    public function __construct(string $email, string $username)
    {
        $this->uuid = Uuid::v4();
        $this->registerAt = new DateTimeImmutable();
        $this->videoViewed = 0;
        $this->email = $email;
        $this->username = $username;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getRegisterAt(): DateTimeImmutable
    {
        return $this->registerAt;
    }

    public function getVideoViewed(): int
    {
        return $this->videoViewed;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function addCourseViewed(): void
    {
        $this->videoViewed++;
    }
}
