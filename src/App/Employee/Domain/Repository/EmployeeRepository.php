<?php

declare(strict_types=1);

namespace App\Employee\Domain\Repository;

use App\Employee\Domain\Employee;
use App\Shared\Domain\Repository\StandardRepository;
use Ecotone\Modelling\Attribute\Repository;

/**
 * Repository for {@see Employee} aggregate
 * @extends StandardRepository<Employee>
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
#[Repository]
interface EmployeeRepository extends StandardRepository
{
}
