<?php

declare(strict_types=1);

namespace App\Fleet\Domain\Service;

use App\Fleet\Domain\ValueObject\FleetManager;
use App\Fleet\Domain\ValueObject\FleetUnitId;

/**
 * Service checking fleet managers permissions related to fleet
 *
 * @author Mariusz Waloszczyk
 */
interface FleetManagerPermissionService
{
    /**
     * Checks if fleet manager is authorized to add a new vehicle in the given unit
     * @param FleetManager $fleetManager
     * @param FleetUnitId $unitId
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public function canAddVehicleToUnit(FleetManager $fleetManager, FleetUnitId $unitId): bool;
}
