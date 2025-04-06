<?php

declare(strict_types=1);

namespace App\Security\Domain\Tenant\Service;

use App\Security\Domain\Tenant\ValueObject\HashedPassword;
use App\Security\Domain\Tenant\ValueObject\PlainPassword;
use App\Security\Domain\Tenant\ValueObject\TenantId;

/**
 * This service is used to perform basic operations with tenant password
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
interface TenantPasswordService
{
    /**
     * Hash password for tenant
     *
     * @param PlainPassword $password
     * @param TenantId $tenantId
     * @return HashedPassword
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function hash(PlainPassword $password, TenantId $tenantId): HashedPassword;

    /**
     * Check if the password is correct for user
     *
     * @param PlainPassword $password
     * @param TenantId $tenantId
     * @return bool
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function isPasswordValid(PlainPassword $password, TenantId $tenantId): bool;
}
