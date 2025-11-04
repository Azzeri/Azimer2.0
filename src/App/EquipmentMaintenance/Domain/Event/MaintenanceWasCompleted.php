<?php

declare(strict_types=1);

namespace App\EquipmentMaintenance\Domain\Event;

use App\EquipmentMaintenance\Domain\ValueObject\EquipmentMaintenanceId;
use Carbon\Carbon;

final readonly class MaintenanceWasCompleted
{
    public function __construct(
        public EquipmentMaintenanceId $maintenanceId,
        public ?Carbon $nextMaintenanceDate = null
    ) {
    }
}
