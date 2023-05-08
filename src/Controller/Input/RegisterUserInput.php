<?php
declare(strict_types=1);

namespace App\Controller\Input;

use App\Entity\UserRole;
use App\Service\Input\RegisterUserInputInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RegisterUserInput extends AbstractType implements RegisterUserInputInterface
{
    private string $email;
    private string $firstName;
    private string $lastName;
    private string $password;
    private int $role;
    private ?string $imagePath;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRole(): int
    {
        return $this->role;
    }

    public function setRole(int $role): void
    {
        $this->role = $role;
    }

    public function getImage(): ?string
    {
        return $this->imagePath;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', EmailType::class)
                ->add('firstName', TextType::class)
                ->add('lastName', TextType::class)
                ->add('password', PasswordType::class)
                ->add('role', ChoiceType::class, [
                    'choices'  => [
                        'User' => UserRole::USER,
                        'Admin' => UserRole::ADMIN,
                    ],
                ])
                ->add('register', SubmitType::class);
    }
}
