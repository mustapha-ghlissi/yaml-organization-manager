<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


class Organization
{
    /**
     * @var string|null
     * @Assert\NotBlank()
     */
    private ?string $name = null;

    /**
     * @var string|null
     * @Assert\NotBlank()
     */
    private ?string $description = null;

    /**
     * @var array|null
     */
    private ?array $users = null;

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
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param array $user
     * @return array|null
     */
    public function addUser(array $user): ?array
    {
        $this->users[] = $user;

        return $this->users;
    }

    /**
     * @return array|null
     */
    public function getUsers(): ?array
    {
        return $this->users;
    }

    /**
     * @param array|null $users
     */
    public function setUsers(?array $users): void
    {
        $this->users = $users;
    }

    /**
     * @param array|null $user
     * @param int $index
     * @return void
     */
    public function setUser(?array $user, int $index): void
    {
        $this->users[$index] = $user;
    }

    /**
     * @return array
     */
    public function __toArray(): array {
        return [
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'users' => $this->getUsers()
        ];
    }
}
