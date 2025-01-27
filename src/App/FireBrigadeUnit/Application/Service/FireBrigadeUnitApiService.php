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
     * Find a single unit by its ID
     *
     * @param string $id - Identifier of the searched unit
     * @return array{
     *     id: string,
     *     superiorUnitId: string,
     *     subservientUnitsIds: array<int,string>
     * }|null
     * @author Mariusz Waloszczyk
     */
    public function findUnitById(string $id): ?array;
}
