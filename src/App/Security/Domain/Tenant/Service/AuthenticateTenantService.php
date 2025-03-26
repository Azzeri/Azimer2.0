<?php

declare(strict_types=1);

namespace App\Security\Domain\Tenant\Service;

use App\Security\Domain\Tenant\ValueObject\AuthenticationToken;
use App\Security\Domain\Tenant\ValueObject\Password;
use App\Security\Domain\Tenant\ValueObject\TenantId;

/**
 * Service used to authenticate tenant in the system
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
interface AuthenticateTenantService
{
    /**
     * Authenticate tenant
     *
     * @param TenantId $tenantId
     * @param Password $password
     * @return AuthenticationToken
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function authenticate(TenantId $tenantId, Password $password): AuthenticationToken;
}
