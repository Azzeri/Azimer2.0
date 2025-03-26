<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Tenant\Policy\TenantCanBeAuthenticated\BusinessRule;

use App\Security\Domain\Tenant\Policy\BusinessRule\TenantIsActive;
use App\Security\Domain\Tenant\ValueObject\Password;
use App\Security\Domain\Tenant\ValueObject\TenantId;
use App\Security\Infrastructure\Tenant\Repository\Persistence\Doctrine\TenantDoctrineRepository;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\Domain\Repository\StandardRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

/**
 * Implementation of {@see TenantIsActive}
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
final readonly class TenantIsActiveImpl implements TenantIsActive
{
    /**
     * @param StandardRepository $tenantRepository
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function __construct(
        #[Autowire(service: TenantDoctrineRepository::class)]
        private StandardRepository $tenantRepository,
    ) {
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function check(TenantId $tenantId, Password $password): ?BusinessRuleNotification
    {
        $tenant = $this->tenantRepository->findById($tenantId);
        return $tenant->isActive()
            ? null
            : BusinessRuleNotification::fromString("Tenant: {$tenantId->email()} is not active");
    }
}
