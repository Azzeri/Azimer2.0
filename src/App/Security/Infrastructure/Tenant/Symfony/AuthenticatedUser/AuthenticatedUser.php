<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Tenant\Symfony\AuthenticatedUser;

use App\Security\Domain\Tenant\Enum\TenantStatus;
use App\Security\Domain\Tenant\Tenant;
use App\Security\Domain\Tenant\ValueObject\Password;
use App\Security\Domain\Tenant\ValueObject\TenantId;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class representing Symfony and Doctrine authenticated user or tenant
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
#[ORM\Entity]
#[ORM\Table(name: 'tenants')]
class AuthenticatedUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: Types::STRING, unique: true)]
    private string $email;

    #[ORM\Column(type: Types::STRING, enumType: TenantStatus::class)]
    private TenantStatus $status;

    #[ORM\Column(type: Types::STRING)]
    private string $password;

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return void
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function setUserIdentifier(string $email): void
    {
        $this->email = $email;
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
     * @param string $password
     * @return void
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return TenantStatus
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function getStatus(): TenantStatus
    {
        return $this->status;
    }

    /**
     * @param TenantStatus $status
     * @return void
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function setStatus(TenantStatus $status): void
    {
        $this->status = $status;
    }

    /**
     * @return array<int,string>
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function getRoles(): array
    {
        // TODO const when role enum is implemented
        return ["IS_AUTHENTICATED"];
    }

    /**
     * Maps authenticated user to a domain Tenant
     *
     * @return Tenant
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function toTenant(): Tenant
    {
        return new Tenant(
            TenantId::fromEmail($this->email),
            Password::fromHashedString($this->password),
            $this->status
        );
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
