<?php

declare(strict_types=1);

namespace App\Fleet\Domain\Policy\AddVehicle\BusinessRule;

use App\Fleet\Domain\Dto\VehicleInputData;
use App\Fleet\Domain\ValueObject\FleetManager;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;

/**
 * All required data has to be provided and valid
 * TODO - maybe won't be necessary after fixing input data
 * @psalm-suppress UnusedClass
 * @author Mariusz Waloszczyk
 */
final class RequiredDataIsProvided implements VehicleCanBeAddedBusinessRule
{
    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function check(
        ?VehicleInputData $inputData = null,
        ?FleetManager $fleetManager = null,
    ): ?BusinessRuleNotification {
        $requiredDataIsPresent = $inputData !== null
            && $inputData->plateNumber !== null
            && $inputData->status !== null
            && $inputData->type !== null
            && $inputData->make !== null
            && $inputData->model !== null
            && $inputData->productionYear !== null
            && $inputData->assignedUnitId !== null;

        return $requiredDataIsPresent
            ? null
            : BusinessRuleNotification::fromString("Required data is missing");
    }
}
