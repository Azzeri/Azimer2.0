<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Tenant\Symfony\AuthenticatedUser;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class representing Symfony and Doctrine authenticated user, used for authentication only
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
final readonly class AuthenticatedUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @param string $email
     * @param string $password
     * @param array $roles
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function __construct(
        private string $email,
        private string $password,
        /** @var array<int, string> $roles */
        private array $roles
    ) {
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return array<int,string>
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function eraseCredentials(): void
    {
        // This method can be left empty if you're not storing sensitive temporary data
    }
}
