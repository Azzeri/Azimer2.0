<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Tenant\Policy\TenantCanBeAuthenticated\BusinessRule;

use App\Security\Domain\Tenant\Policy\BusinessRule\TenantIsActive;
use App\Security\Domain\Tenant\Repository\TenantRepository;
use App\Security\Domain\Tenant\ValueObject\PlainPassword;
use App\Security\Domain\Tenant\ValueObject\TenantId;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;

/**
 * Implementation of {@see TenantIsActive}
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
final readonly class TenantIsActiveImpl implements TenantIsActive
{
    /**
     * @param TenantRepository $tenantRepository
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function __construct(
        private TenantRepository $tenantRepository,
    ) {
    }

    /**
     * @inheritDoc
     * @throws ResourceNotFoundException
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function check(TenantId $tenantId, PlainPassword $password): ?BusinessRuleNotification
    {
        $tenant = $this->tenantRepository->findById($tenantId);
        return $tenant->isActive()
            ? null
            : BusinessRuleNotification::fromString("Tenant: {$tenantId->email()} is not active");
    }
}
