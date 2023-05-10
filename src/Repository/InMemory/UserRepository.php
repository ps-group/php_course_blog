<?php
declare(strict_types=1);

namespace App\Repository\InMemory;

use App\Entity\User;
use App\Repository\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
     /** @var array<string, User>  */
    private array $users = [];

    public function findById(int $id): ?User
    {
        return null;
    }

    public function listUsers(array $ids): array
    {
        return [];
    }

    public function findByEmail(string $email): ?User
    {
        foreach ($this->users as $user)
        {
            if ($user->getEmail() === $email)
            {
                return $user;
            }
        }
        return null;
    }

    public function store(User $user): int
    {
        $id = count($this->users) + 1;
        $this->users[$id] = $user;
        return $id;
    }

    public function delete(User $user): void
    {}

    public function getUsersCount(): int
    {
        return count($this->users);
    }
}