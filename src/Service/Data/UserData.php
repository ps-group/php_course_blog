<?php
declare(strict_types=1);

namespace App\Service\Data;

class UserData
{
    private int $id;
    private string $email;
    private string $firstName;
    private string $lastName;
    private int $role;
    private ?string $imagePath;

    public function __construct(
        int $id,
        string $email,
        string $firstName,
        string $lastName,
        int $role,
        ?string $imagePath)
    {
        $this->id = $id;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->role = $role;
        $this->imagePath = $imagePath;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getRole(): int
    {
        return $this->role;
    }

    public function getImage(): ?string
    {
        return $this->imagePath;
    }
}
