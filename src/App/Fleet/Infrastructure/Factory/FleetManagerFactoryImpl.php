<?php

declare(strict_types=1);

namespace App\Fleet\Infrastructure\Factory;

use App\Employee\Application\Service\EmployeeApiService;
use App\Fleet\Domain\Enum\FleetPermission;
use App\Fleet\Domain\Factory\FleetManagerFactory;
use App\Fleet\Domain\ValueObject\FleetManager;
use App\Fleet\Domain\ValueObject\FleetUnitId;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;

/**
 * Implementation of {@see FleetManagerFactory}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class FleetManagerFactoryImpl implements FleetManagerFactory
{
    /**
     * @param EmployeeApiService $employeeApiService
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        private EmployeeApiService $employeeApiService,
    ) {
    }

    /**
     * @inheritDoc
     * @throws ResourceNotFoundException|InvalidDataException
     * @author Mariusz Waloszczyk
     */
    public function fromAuthenticatedEmployee(): FleetManager
    {
        $authenticatedEmployee = $this->employeeApiService
            ->getAuthenticatedEmployee();

        $permissions = [];
        foreach ($authenticatedEmployee['resources'] as $resource) {
            $fleetPermission = FleetPermission::tryFrom($resource);
            if ($fleetPermission !== null) {
                $permissions[] = $fleetPermission;
            }
        }

        return FleetManager::create(
            FleetUnitId::fromString($authenticatedEmployee['fireBrigadeUnitId']),
            $permissions
        );
    }
}
