<?php

declare(strict_types=1);

namespace App\Security\Domain\Tenant\Policy\BusinessRule;

/**
 * Business rule responsible for checking validity of provided password and tenantId
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
interface PasswordAndEmailAreCorrect extends TenantCanBeAuthenticatedBusinessRule
{
}
