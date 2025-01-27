<?php

declare(strict_types=1);

namespace App\Fleet\Domain\Policy\AddVehicle\BusinessRule;

use App\Fleet\Domain\Dto\VehicleInputData;
use App\Fleet\Domain\ValueObject\FleetManager;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;

/**
 * A single business rule that needs to be valid to create a new vehicle
 *
 * @author Mariusz Waloszczyk
 */
interface VehicleCanBeAddedBusinessRule
{
    /**
     * A single business rule that needs to be valid to create a new vehicle
     *
     * @param VehicleInputData|null $inputData
     * @param FleetManager|null $fleetManager
     * @return BusinessRuleNotification|null
     * @author Mariusz Waloszczyk
     */
    public function check(
        ?VehicleInputData $inputData = null,
        ?FleetManager $fleetManager = null,
    ): ?BusinessRuleNotification;
}
