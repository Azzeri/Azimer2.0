<?php

declare(strict_types=1);

namespace App\Security\Domain\Tenant;

use App\Security\Domain\Tenant\Enum\TenantStatus;
use App\Security\Domain\Tenant\ValueObject\Password;
use App\Security\Domain\Tenant\ValueObject\TenantId;
use App\Shared\DomainUtilities\Domain\AggregateRoot;

/**
 * Aggregate of Tenant, which is an authenticated user in the system
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
final class Tenant extends AggregateRoot
{
    /**
     * @param TenantId $id
     * @param Password $password
     * @param TenantStatus $status
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function __construct(
        private TenantId $id,
        private Password $password,
        private TenantStatus $status,
    ) {
    }

    /**
     * @return bool
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function isActive(): bool
    {
        return $this->status === TenantStatus::ACTIVE;
    }
}
