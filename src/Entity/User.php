<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class User
{
    /**
     * @var string|null
     * @Assert\NotBlank()
     */
    private ?string $name = null;

    /**
     * @var array|null
     * @Assert\NotBlank()
     */
    private ?array $role = null;

    /**
     * @var string|null
     * @Assert\NotBlank()
     */
    private ?string $password = null;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return array|null
     */
    public function getRole(): ?array
    {
        return $this->role;
    }

    /**
     * @param array|null $role
     */
    public function setRole(?array $role): void
    {
        $this->role = $role;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return array
     */
    public function __toArray(): array {
        return [
            'name' => $this->getName(),
            'role' => $this->getRole(),
            'password' => $this->getPassword()
        ];
    }
}
