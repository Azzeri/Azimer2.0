<?php

declare(strict_types=1);

namespace App\Fleet\Domain\Policy\AddVehicle;

use App\Fleet\Domain\Dto\VehicleInputData;
use App\Fleet\Domain\ValueObject\FleetManager;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;

/**
 * Policy checking if all business rules to create a vehicle are valid
 *
 * @author Mariusz Waloszczyk
 */
interface VehicleCanBeAdded
{
    /**
     * Check if all business rules to create a vehicle are valid, and return a collection of violations
     *
     * @param VehicleInputData|null $inputData
     * @param FleetManager|null $fleetManager
     * @return BusinessRulesNotificationsCollection
     * @author Mariusz Waloszczyk
     */
    public function isSatisfiedBy(
        ?VehicleInputData $inputData = null,
        ?FleetManager $fleetManager = null
    ): BusinessRulesNotificationsCollection;
}
