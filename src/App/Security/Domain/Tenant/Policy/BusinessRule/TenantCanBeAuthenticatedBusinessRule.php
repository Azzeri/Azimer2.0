<?php

declare(strict_types=1);

namespace App\Security\Domain\Tenant\Policy\BusinessRule;

use App\Security\Domain\Tenant\ValueObject\PlainPassword;
use App\Security\Domain\Tenant\ValueObject\TenantId;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

/**
 * Single business rule checking if tenant can be authenticated
 *
 * @author Mariusz Waloszczyk
 */
#[AutoconfigureTag(TenantCanBeAuthenticatedBusinessRule::class)]
interface TenantCanBeAuthenticatedBusinessRule
{
    /**
     * Checks a single rule
     *
     * @param TenantId $tenantId
     * @param PlainPassword $password
     * @return BusinessRuleNotification|null
     * @author Mariusz Waloszczyk
     */
    public function check(TenantId $tenantId, PlainPassword $password): ?BusinessRuleNotification;
}
