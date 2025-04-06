<?php

declare(strict_types=1);

namespace App\Security\Domain\Tenant\Service;

use App\Security\Domain\Tenant\ValueObject\AuthenticationToken;
use App\Security\Domain\Tenant\ValueObject\PlainPassword;
use App\Security\Domain\Tenant\ValueObject\TenantId;

/**
 * Service used to authenticate tenant in the system
 *
 * @author Mariusz Waloszczyk
 */
interface AuthenticateTenantService
{
    /**
     * Authenticate tenant
     *
     * @param TenantId $tenantId
     * @param PlainPassword $password
     * @return AuthenticationToken
     * @author Mariusz Waloszczyk
     */
    public function authenticate(TenantId $tenantId, PlainPassword $password): AuthenticationToken;
}
