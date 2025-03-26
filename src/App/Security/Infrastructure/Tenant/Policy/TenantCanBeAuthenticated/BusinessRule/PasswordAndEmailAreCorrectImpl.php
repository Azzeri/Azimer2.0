<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Tenant\Policy\TenantCanBeAuthenticated\BusinessRule;

use App\Security\Domain\Tenant\Policy\BusinessRule\PasswordAndEmailAreCorrect;
use App\Security\Domain\Tenant\ValueObject\Password;
use App\Security\Domain\Tenant\ValueObject\TenantId;
use App\Security\Infrastructure\Tenant\Symfony\AuthenticatedUser\AuthenticatedUserProvider;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Implementation of {@see PasswordAndEmailAreCorrect}
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
final readonly class PasswordAndEmailAreCorrectImpl implements PasswordAndEmailAreCorrect
{
    /**
     * @param AuthenticatedUserProvider $authenticatedUserProvider
     * @param UserPasswordHasherInterface $passwordHasher
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function __construct(
        private AuthenticatedUserProvider $authenticatedUserProvider,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function check(
        TenantId $tenantId,
        Password $password
    ): ?BusinessRuleNotification {
        try {
            $tenant = $this->authenticatedUserProvider->loadUserByIdentifier($tenantId->email());
        } catch (ResourceNotFoundException) {
            return BusinessRuleNotification::fromString("Tenant: {$tenantId->email()} not found");
        }

        $isPasswordValid = $this->passwordHasher->isPasswordValid($tenant, $password->nonHashed());
        return $isPasswordValid
            ? null
            : BusinessRuleNotification::fromString("Incorrect password");
    }
}
