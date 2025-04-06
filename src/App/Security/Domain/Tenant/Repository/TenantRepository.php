<?php

declare(strict_types=1);

namespace App\Security\Domain\Tenant\Repository;

use App\Security\Domain\Tenant\Tenant;
use App\Shared\Domain\Repository\StandardRepository;

/**
 * Repository of {@see Tenant aggregate}
 * @extends StandardRepository<Tenant>
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
interface TenantRepository extends StandardRepository
{
}
