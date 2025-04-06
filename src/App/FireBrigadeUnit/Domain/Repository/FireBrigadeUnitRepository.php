<?php

declare(strict_types=1);

namespace App\FireBrigadeUnit\Domain\Repository;

use App\FireBrigadeUnit\Domain\FireBrigadeUnit;
use App\Shared\Domain\Repository\StandardRepository;
use Ecotone\Modelling\Attribute\Repository;

/**
 * Repository for {@see FireBrigadeUnit} aggregate
 * @extends StandardRepository<FireBrigadeUnit>
 *
 * @author Mariusz Waloszczyk
 */
#[Repository]
interface FireBrigadeUnitRepository extends StandardRepository
{
}
