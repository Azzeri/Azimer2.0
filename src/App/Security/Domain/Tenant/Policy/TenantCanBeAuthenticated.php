<?php

declare(strict_types=1);

namespace App\Security\Domain\Tenant\Policy;

use App\Security\Domain\Tenant\ValueObject\Password;
use App\Security\Domain\Tenant\ValueObject\TenantId;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;

/**
 * Policy checking if tenant can be authenticated
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
interface TenantCanBeAuthenticated
{
    /**
     * Check if the policy is satisfied by business rules
     *
     * @param TenantId $tenantId
     * @param Password $password
     * @return BusinessRulesNotificationsCollection
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function isSatisfiedBy(TenantId $tenantId, Password $password): BusinessRulesNotificationsCollection;
}
