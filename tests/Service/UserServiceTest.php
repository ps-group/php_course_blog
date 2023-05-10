<?php
declare(strict_types=1);

namespace App\Tests\Service;

use App\Controller\Input\RegisterUserInput;
use App\Entity\UserRole;
use App\Repository\InMemory\UserRepository;
use App\Service\PasswordHasher;
use App\Service\UserService;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    /** @var UserRepository */
    private $repository;
    /** @var UserService */
    private $service;

    public function testRegisterUser(): void
    {
        $input = new RegisterUserInput();
        $input->setEmail('test@mail.ru');
        $input->setFirstName('Test First Name');
        $input->setLastName('Test Last Name');
        $input->setPassword('1234');
        $input->setRole(UserRole::USER);

        $this->assertEquals(0, $this->repository->getUsersCount());
        $this->service->register($input);
        $this->assertEquals(1, $this->repository->getUsersCount());
    }

    public function testCanNotRegisterUserWithInvalidRole(): void
    {
        $input = new RegisterUserInput();
        $input->setEmail('test@mail.ru');
        $input->setFirstName('Test First Name');
        $input->setLastName('Test Last Name');
        $input->setPassword('1234');
        $input->setRole(0);

        $this->expectException(\InvalidArgumentException::class);
        $this->assertEquals(0, $this->repository->getUsersCount());
        $this->service->register($input);
    }

    public function testCanNotRegisterAlreadyExistingUser(): void
    {
        $input = new RegisterUserInput();
        $input->setEmail('test@mail.ru');
        $input->setFirstName('Test First Name');
        $input->setLastName('Test Last Name');
        $input->setPassword('1234');
        $input->setRole(1);

        $this->service->register($input);

        $this->assertEquals(1, $this->repository->getUsersCount());
        $this->expectException(\InvalidArgumentException::class);
        $this->service->register($input);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new UserRepository();
        $this->service = new UserService($this->repository, new PasswordHasher());
    }
}