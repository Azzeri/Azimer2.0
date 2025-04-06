<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Tenant\Symfony\AuthenticatedUser;

use App\Security\Domain\Tenant\Repository\TenantQueryRepository;
use App\Security\Domain\Tenant\ValueObject\TenantId;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Implementation of {@see UserProviderInterface}
 * @implements UserProviderInterface<AuthenticatedUser>
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
final readonly class AuthenticatedUserProvider implements UserProviderInterface
{
    /**
     * @param TenantQueryRepository $tenantQueryRepository
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function __construct(private TenantQueryRepository $tenantQueryRepository)
    {
    }

    /**
     * @inheritDoc
     * @throws ResourceNotFoundException
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->tenantQueryRepository->findByIdentifier(TenantId::fromEmail($identifier));

        if ($user === null) {
            throw new ResourceNotFoundException("User with identifier '$identifier' not found");
        }

        return new AuthenticatedUser(
            $user->email,
            $user->password,
            $user->roles
        );
    }

    /**
     * @inheritDoc
     * @throws ResourceNotFoundException
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof AuthenticatedUser) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }

        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function supportsClass(string $class): bool
    {
        return AuthenticatedUser::class === $class || is_subclass_of($class, AuthenticatedUser::class);
    }
}
