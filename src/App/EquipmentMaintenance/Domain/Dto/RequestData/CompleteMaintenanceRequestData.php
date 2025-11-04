<?php

declare(strict_types=1);

namespace App\EquipmentMaintenance\Domain\Dto\RequestData;

use App\Shared\DomainUtilities\Domain\DataTransferObject;

final readonly class CompleteMaintenanceRequestData extends DataTransferObject
{
    public function __construct(
        public string $performedBy,
        public string $startedAt,
        public string $finishedAt,
        public ?string $nextMaintenanceStartDate = null,
    ) {
    }
}
