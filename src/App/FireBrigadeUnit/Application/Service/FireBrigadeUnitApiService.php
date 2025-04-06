<?php

declare(strict_types=1);

namespace App\FireBrigadeUnit\Application\Service;

/**
 * This service can be used by other bounded contexts to fetch data about units
 *
 * @author Mariusz Waloszczyk
 */
interface FireBrigadeUnitApiService
{
    /**
     * @param string $unitToCheck
     * @param string $unitToCheckAgainst
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public function isUnitSuperiorTo(string $unitToCheck, string $unitToCheckAgainst): bool;

    /**
     * @param string $unitToCheck
     * @param string $unitToCheckAgainst
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public function isUnitSubservientTo(string $unitToCheck, string $unitToCheckAgainst): bool;
}
