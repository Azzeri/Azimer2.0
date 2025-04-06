<?php

namespace App\Fleet\Infrastructure\Policy\AddVehicle\BusinessRule;

use App\Fleet\Application\Command\AddVehicleCommand;
use App\Fleet\Domain\Policy\AddVehicle\BusinessRule\FleetManagerIsAuthorized;
use App\Fleet\Domain\Service\FleetManagerPermissionService;
use App\Fleet\Domain\ValueObject\FleetManager;
use App\Fleet\Domain\ValueObject\FleetUnitId;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\DomainUtilities\Exception\InvalidDataException;

/**
 * Adapter of {@see FleetManagerIsAuthorized}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class FleetManagerIsAuthorizedImpl implements FleetManagerIsAuthorized
{
    /**
     * @param FleetManagerPermissionService $fleetManagerPermissionService
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        private FleetManagerPermissionService $fleetManagerPermissionService,
    ) {
    }

    /**
     * @inheritDoc
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    public function check(AddVehicleCommand $command, FleetManager $fleetManager): ?BusinessRuleNotification
    {
        $canAddVehicleToUnit = $this->fleetManagerPermissionService->canAddVehicleToUnit(
            $fleetManager,
            FleetUnitId::fromString($command->assignedUnitId)
        );

        return $canAddVehicleToUnit
            ? null
            : BusinessRuleNotification::fromString("Fleet manager not authorized to manage this unit");
    }
}
