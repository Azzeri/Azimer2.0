<?php

declare(strict_types=1);

namespace App\EquipmentMaintenance\Domain\Event;

use Ecotone\Modelling\CommandBus;

final readonly class MaintenanceWasCompletedThenCreateNextMaintenance
{
    public function __construct(private CommandBus $commandBus)
    {
    }

    public function __invoke(MaintenanceWasCompleted $maintenanceWasCompletedEvent): void
    {
//        if ($maintenanceWasCompletedEvent->nextMaintenanceDate !== null) {
//            $this->commandBus->send('create.maintenance.command');
//        }
    }
}
