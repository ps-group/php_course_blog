<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Entity\UserRole;
use App\Repository\UserRepositoryInterface;
use App\Service\Input\RegisterUserInputInterface;

class UserService
{
    private UserRepositoryInterface $repository;
    private PasswordHasher $passwordHasher;

    public function __construct(UserRepositoryInterface $postRepository, PasswordHasher $passwordHasher)
    {
        $this->repository = $postRepository;
        $this->passwordHasher = $passwordHasher;
    }

    public function register(RegisterUserInputInterface $input): int
    {
        $existingUser = $this->repository->findByEmail($input->getEmail());
        if ($existingUser !== null)
        {
            throw new \InvalidArgumentException("User with email " . $input->getEmail() . " already has been registered");
        }
        if (!UserRole::isValid($input->getRole()))
        {
            throw new \InvalidArgumentException("Role is not valid " . $input->getRole());
        }

        $user = new User(
            null,
            $input->getEmail(),
            $input->getFirstName(),
            $input->getLastName(),
            $this->passwordHasher->hash($input->getPassword()),
            $input->getRole(),
            null
        );
        return $this->repository->store($user);
    }
}