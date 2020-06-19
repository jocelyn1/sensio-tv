<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{
    public const ROLE = 'ROLE_USER';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(length=180, unique=true)
     */
    private $email = '';

    /**
     * @var string The hashed password
     *
     * @ORM\Column
     */
    private $password = '';

    /**
     * @var \DateTimeImmutable|null
     *
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $birthday;

    public function getId(): ?int
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

    /**
     * {@inheritdoc}
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles(): array
    {
        return [self::ROLE];
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
        // noop
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getBirthday(): ?\DateTimeImmutable
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeImmutable $birthday): void
    {
        $this->birthday = $birthday;
    }
}
