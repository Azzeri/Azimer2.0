<?php

declare(strict_types=1);

namespace App\Security\Domain\Tenant\Policy\BusinessRule;

/**
 * Business rule responsible for checking if tenant is active
 *
 * @author Mariusz Waloszczyk
 */
interface TenantIsActive extends TenantCanBeAuthenticatedBusinessRule
{
}
