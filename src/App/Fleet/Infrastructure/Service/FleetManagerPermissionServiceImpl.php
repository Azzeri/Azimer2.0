<?php

declare(strict_types=1);

namespace App\Fleet\Infrastructure\Service;

use App\FireBrigadeUnit\Application\Service\FireBrigadeUnitApiService;
use App\Fleet\Domain\Service\FleetManagerPermissionService;
use App\Fleet\Domain\ValueObject\FleetManager;
use App\Fleet\Domain\ValueObject\FleetUnitId;

/**
 * Implements {@see FleetManagerPermissionService}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class FleetManagerPermissionServiceImpl implements FleetManagerPermissionService
{
    /**
     * @param FireBrigadeUnitApiService $fireBrigadeUnitApiService
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        private FireBrigadeUnitApiService $fireBrigadeUnitApiService,
    ) {
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function canAddVehicleToUnit(FleetManager $fleetManager, FleetUnitId $unitId): bool
    {
        if ($fleetManager->canAddFleetToAllUnits()) {
            return true;
        }

        if ($fleetManager->canAddFleetToOwnUnit() && $fleetManager->isAssignedToUnit($unitId)) {
            return true;
        }

        $isManagerUnitSuperiorToRequestedUnit = $this->fireBrigadeUnitApiService->isUnitSubservientTo(
            (string)$unitId,
            (string)$fleetManager->assignedUnitId()
        );

        return $fleetManager->canAddFleetToSubservientUnits() && $isManagerUnitSuperiorToRequestedUnit;
    }
}
