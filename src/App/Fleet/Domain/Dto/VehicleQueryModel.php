<?php

declare(strict_types=1);

namespace App\Fleet\Domain\Dto;

/**
 * Vehicle query model
 *
 * @author Mariusz Waloszczyk
 */
final readonly class VehicleQueryModel
{
    /**
     * @param string $plateNumber
     * @param string $status
     * @param string $type
     * @param string $make
     * @param string $model
     * @param int $productionYear
     * @param string $assignedUnitId
     * @param int|null $productionMonth
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        public string $plateNumber,
        public string $status,
        public string $type,
        public string $make,
        public string $model,
        public int $productionYear,
        public string $assignedUnitId,
        public ?int $productionMonth = null,
    ) {
    }
}
