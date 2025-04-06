<?php

declare(strict_types=1);

namespace App\Fleet\Application\Command;

/**
 * Command to create a new vehicle
 *
 * @author Mariusz Waloszczyk
 */
final readonly class AddVehicleCommand
{
    /**
     * @param string $plateNumber
     * @param string $status
     * @param string $type
     * @param string $make
     * @param string $model
     * @param int|null $productionYear
     * @param int|null $productionMonth
     * @param string|null $assignedUnitId
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        public string $plateNumber,
        public string $status,
        public string $type,
        public string $make,
        public string $model,
        public ?int $productionYear = null,
        public ?int $productionMonth = null,
        public ?string $assignedUnitId = null
    ) {
    }
}
