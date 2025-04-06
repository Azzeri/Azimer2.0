<?php

namespace Tests\Unit\App\Fleet\Domain\ValueObject;

use App\Fleet\Domain\ValueObject\FleetManager;
use App\Fleet\Domain\ValueObject\FleetUnitId;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use Symfony\Component\Uid\Uuid;

it(
    'can not manage units without permissions',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $manager = FleetManager::create(FleetUnitId::fromString(Uuid::v4()->toString()), []);

        // Act // Assert
        expect($manager->canAddFleetToAllUnits())->toBeFalse()
            ->and($manager->canAddFleetToOwnUnit())->toBeFalse()
            ->and($manager->canAddFleetToSubservientUnits())->toBeFalse();
    }
);
it(
    'is assigned to the unit',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $fleetUnit = FleetUnitId::fromString(Uuid::v4()->toString());
        $invalidFleetUnit = FleetUnitId::fromString(Uuid::v4()->toString());
        $manager = FleetManager::create($fleetUnit, []);

        // Act // Assert
        expect($manager->isAssignedToUnit($fleetUnit))->toBeTrue()
            ->and($manager->isAssignedToUnit($invalidFleetUnit))->toBeFalse()
            ->and($manager->assignedUnitId()->equals($fleetUnit))->toBeTrue();
    }
);
