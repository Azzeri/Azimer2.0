<?php

declare(strict_types=1);

namespace App\Fleet\Domain\Dto;

/**
 * Input data required to create/update a vehicle
 *
 * @author Mariusz Waloszczyk
 */
final readonly class VehicleInputData
{
    /**
     * @param string|null $plateNumber
     * @param string|null $status
     * @param string|null $type
     * @param string|null $make
     * @param string|null $model
     * @param int|null $productionYear
     * @param int|null $productionMonth
     * @param string|null $assignedUnitId
     *
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        public ?string $plateNumber = null,
        public ?string $status = null,
        public ?string $type = null,
        public ?string $make = null,
        public ?string $model = null,
        public ?int $productionYear = null,
        public ?int $productionMonth = null,
        public ?string $assignedUnitId = null
    ) {
    }
}
