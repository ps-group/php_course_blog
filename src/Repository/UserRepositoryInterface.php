<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;

    /**
     * @param int[] $ids
     * @return User[]
     */
    public function listUsers(array $ids): array;

    public function findByEmail(string $email): ?User;

    public function store(User $user): int;

    public function delete(User $user): void;
}