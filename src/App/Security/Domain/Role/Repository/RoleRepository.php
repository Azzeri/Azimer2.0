<?php

declare(strict_types=1);

namespace App\Security\Domain\Role\Repository;

use App\Security\Domain\Role\Role;
use App\Shared\Domain\Repository\StandardRepository;

/**
 * Repository for {@see Role} aggregate
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
interface RoleRepository extends StandardRepository
{
}
