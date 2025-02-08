<?php

namespace App\Fleet\Infrastructure\Policy\AddVehicle\BusinessRule;

use App\Fleet\Domain\Dto\VehicleInputData;
use App\Fleet\Domain\Factory\AssignedUnitFactory;
use App\Fleet\Domain\Factory\FleetManagerFactory;
use App\Fleet\Domain\Policy\AddVehicle\BusinessRule\FleetManagerIsAuthorized;
use App\Fleet\Domain\ValueObject\AssignedUnitId;
use App\Fleet\Domain\ValueObject\FleetManager;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;

/**
 * Adapter of {@see FleetManagerIsAuthorized}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class FleetManagerIsAuthorizedImpl implements FleetManagerIsAuthorized
{
    /**
     * @param FleetManagerFactory $fleetManagerFactory
     * @param AssignedUnitFactory $fireBrigadeUnitFactory
     */
    public function __construct(
        private FleetManagerFactory $fleetManagerFactory,
        private AssignedUnitFactory $fireBrigadeUnitFactory,
    ) {
    }

    /**
     * @inheritDoc
     * @throws ResourceNotFoundException|InvalidDataException
     * @author Mariusz Waloszczyk
     */
    public function check(
        ?VehicleInputData $inputData = null,
        ?FleetManager $fleetManager = null,
    ): ?BusinessRuleNotification {
        $fleetManager = $this->fleetManagerFactory
            ->fromAuthenticatedUser();

        $unitToCheck = $this->fireBrigadeUnitFactory
            ->createFromIdentifier(AssignedUnitId::fromString($inputData->assignedUnitId));

        return $fleetManager->canAddFleetToUnit($unitToCheck)
            ? null
            : BusinessRuleNotification::fromString("Fleet manager not authorized to manage this unit");
    }
}
