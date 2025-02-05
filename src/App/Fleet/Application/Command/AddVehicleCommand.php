<?php

declare(strict_types=1);

namespace App\Fleet\Application\Command;

use App\Fleet\Domain\Dto\VehicleInputData;

/**
 * Add a new vehicle from input data
 *
 * @author Mariusz Waloszczyk
 */
final readonly class AddVehicleCommand
{
    /**
     * @param VehicleInputData $vehicleInputData
     */
    public function __construct(
        public VehicleInputData $vehicleInputData
    ) {
    }
}
