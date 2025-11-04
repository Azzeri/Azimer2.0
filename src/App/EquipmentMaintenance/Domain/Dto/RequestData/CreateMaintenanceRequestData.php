<?php

declare(strict_types=1);

namespace App\EquipmentMaintenance\Domain\Dto\RequestData;

use App\Shared\DomainUtilities\Domain\DataTransferObject;

final readonly class CreateMaintenanceRequestData extends DataTransferObject
{
    public function __construct(
        public string $equipmentId,
        public string $assignedTo,
        public string $plannedStartDate,
        public ?string $description = null,
        public ?int $daysUntilNextMaintenanceDate = null,
    ) {
    }
}
