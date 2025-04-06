<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Tenant\Service;

use App\Security\Domain\Tenant\Service\TenantPasswordService;
use App\Security\Domain\Tenant\ValueObject\HashedPassword;
use App\Security\Domain\Tenant\ValueObject\PlainPassword;
use App\Security\Domain\Tenant\ValueObject\TenantId;
use App\Security\Infrastructure\Tenant\Symfony\AuthenticatedUser\AuthenticatedUser;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Implements {@see TenantPasswordService}
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
final readonly class TenantPasswordServiceImpl implements TenantPasswordService
{
    /**
     * @param UserPasswordHasherInterface $passwordHasher
     * @param UserProviderInterface $userProvider
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private UserProviderInterface $userProvider,
    ) {
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function hash(PlainPassword $password, TenantId $tenantId): HashedPassword
    {
        $authenticatedUser = new AuthenticatedUser(
            $tenantId->email(),
            $password->toString(),
            []
        );
        $hashedPassword = $this->passwordHasher->hashPassword($authenticatedUser, $password->toString());

        return HashedPassword::fromString($hashedPassword);
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function isPasswordValid(PlainPassword $password, TenantId $tenantId): bool
    {
        $authenticatedUser = $this->userProvider->loadUserByIdentifier($tenantId->email());
        return $this->passwordHasher->isPasswordValid($authenticatedUser, $password->toString());
    }
}
