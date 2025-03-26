<?php

declare(strict_types=1);

namespace App\Security\Domain\Tenant\Enum;

/**
 * Available statuses of tenants
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
enum TenantStatus: string
{
    case ACTIVE = 'Active';
    case INACTIVE = 'Inactive';
}
