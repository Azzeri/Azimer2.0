<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Tenant\Service;

use App\Security\Application\Tenant\Service\SecurityApiService;
use App\Security\Domain\Tenant\Repository\TenantQueryRepository;
use App\Security\Domain\Tenant\ValueObject\TenantId;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Implementation of {@see SecurityApiService}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class SecurityApiServiceImpl implements SecurityApiService
{
    /**
     * @param Security $security
     * @param TenantQueryRepository $tenantQueryRepository
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        private Security $security,
        private TenantQueryRepository $tenantQueryRepository
    ) {
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function getAuthenticatedTenant(): array
    {
        $authenticatedUser = $this->security->getUser();
        $tenant = $this->tenantQueryRepository->findByIdentifier(
            TenantId::fromEmail($authenticatedUser->getUserIdentifier())
        );

        if (null === $tenant) {
            throw new ResourceNotFoundException("Failed to get authenticated tenant");
        }

        return [
            'id' => $tenant->email,
            'permissions' => $tenant->resources,
        ];
    }
}
