<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Tenant\Service;

use App\Security\Domain\Tenant\Policy\TenantCanBeAuthenticated;
use App\Security\Domain\Tenant\Service\AuthenticateTenantService;
use App\Security\Domain\Tenant\ValueObject\AuthenticationToken;
use App\Security\Domain\Tenant\ValueObject\PlainPassword;
use App\Security\Domain\Tenant\ValueObject\TenantId;
use App\Security\Infrastructure\Tenant\Symfony\AuthenticatedUser\AuthenticatedUserProvider;
use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

/**
 * Implementation of {@see AuthenticateTenantService}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class AuthenticateTenantServiceImpl implements AuthenticateTenantService
{
    /**
     * @param AuthenticatedUserProvider $authenticatedUserProvider
     * @param TenantCanBeAuthenticated $tenantCanBeAuthenticated
     * @param JWTTokenManagerInterface $jwtManager
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        private AuthenticatedUserProvider $authenticatedUserProvider,
        private TenantCanBeAuthenticated $tenantCanBeAuthenticated,
        private JWTTokenManagerInterface $jwtManager
    ) {
    }

    /**
     * @inheritDoc
     * @throws BusinessRuleViolationException|ResourceNotFoundException
     * @author Mariusz Waloszczyk
     */
    public function authenticate(TenantId $tenantId, PlainPassword $password): AuthenticationToken
    {
        $this->tenantCanBeAuthenticated->isSatisfiedBy($tenantId, $password)
            ->validate();

        $authenticatedUser = $this->authenticatedUserProvider
            ->loadUserByIdentifier($tenantId->email());

        return AuthenticationToken::fromString($this->jwtManager->create($authenticatedUser));
    }
}
