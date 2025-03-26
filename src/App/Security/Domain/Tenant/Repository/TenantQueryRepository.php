<?php

declare(strict_types=1);

namespace App\Security\Domain\Tenant\Repository;

use App\Security\Domain\Tenant\Dto\TenantQueryModel;
use App\Security\Domain\Tenant\ValueObject\TenantId;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;

/**
 * Repository for a tenant query model
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
interface TenantQueryRepository
{
    /**
     * Find by identifier
     *
     * @param TenantId $identifier
     * @return TenantQueryModel|null
     * @throws ResourceNotFoundException
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function findByIdentifier(TenantId $identifier): ?TenantQueryModel;
}
