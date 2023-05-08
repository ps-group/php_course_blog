<?php
declare(strict_types=1);

namespace App\Service\Input;

interface RegisterUserInputInterface
{
    public function getEmail(): string;

    public function getFirstName(): string;

    public function getLastName(): string;

    public function getPassword(): string;

    public function getRole(): int;

    public function getImage(): ?string;
}