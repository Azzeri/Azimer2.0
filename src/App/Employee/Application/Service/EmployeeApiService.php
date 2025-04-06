<?php

declare(strict_types=1);

namespace App\Employee\Application\Service;

use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;

/**
 * This service should be used by other bounded contexts to get information about employees
 *
 * @author Mariusz Waloszczyk
 */
interface EmployeeApiService
{
    /**
     * Get employee which is currently using the system
     *
     * @return array{
     *     id: string,
     *     fireBrigadeUnitId: string,
     *     resources: array<int,string>
     * }
     * @throws ResourceNotFoundException
     * @author Mariusz Waloszczyk
     */
    public function getAuthenticatedEmployee(): array;
}
