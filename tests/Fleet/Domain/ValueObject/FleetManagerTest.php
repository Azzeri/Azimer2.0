<?php

namespace App\Tests\Fleet\Domain\ValueObject;

use App\Fleet\Domain\Enum\FleetPermission;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Tests\SampleProvider\Fleet\FleetSamples;
use Symfony\Component\Uid\Uuid;

it(
    'can add vehicle to unit if has overall units resource',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $manager = FleetSamples::fleetManager([FleetPermission::ADD_ALL]);

        // Act // Assert
        expect($manager->canAddFleetToUnit(FleetSamples::assignedUnit()))->toBeTrue();
    }
);
it(
    'can add vehicle to own unit if has required resource and belongs to unit',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $unitOfManager = Uuid::v4();
        $manager = FleetSamples::fleetManager([FleetPermission::ADD_OWN], $unitOfManager);

        // Act // Assert
        expect($manager->canAddFleetToUnit(FleetSamples::assignedUnit(id: $unitOfManager)))->toBeTrue();
    }
);

it(
    'can add vehicle to subservient unit if has required resource and unit is subservient to his unit',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $unitOfManager = Uuid::v4();
        $subservientUnit = Uuid::v4();
        $manager = FleetSamples::fleetManager([FleetPermission::ADD_SUBSERVIENT], $unitOfManager);

        // Act // Assert
        expect(
            $manager->canAddFleetToUnit(
                FleetSamples::assignedUnit(
                    id: $subservientUnit,
                    superiorUnitId: $unitOfManager
                )
            )
        )->toBeTrue();
    }
);

it(
    'can\'t add vehicle to own unit without resource',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $unitOfManager = Uuid::v4();
        $manager = FleetSamples::fleetManager([], $unitOfManager);

        // Act // Assert
        expect($manager->canAddFleetToUnit(FleetSamples::assignedUnit(id: $unitOfManager)))->toBeFalse();
    }
);

it(
    'can\'t add vehicle to subservient unit without resource',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $unitOfManager = Uuid::v4();
        $subservientUnit = Uuid::v4();
        $manager = FleetSamples::fleetManager([], $unitOfManager);

        // Act // Assert
        expect(
            $manager->canAddFleetToUnit(
                FleetSamples::assignedUnit(
                    id: $subservientUnit,
                    superiorUnitId: $unitOfManager
                )
            )
        )->toBeFalse();
    }
);

it(
    'can\'t add vehicle to non-own unit with own unit resource',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $manager = FleetSamples::fleetManager([FleetPermission::ADD_OWN]);

        // Act // Assert
        expect($manager->canAddFleetToUnit(FleetSamples::assignedUnit()))->toBeFalse();
    }
);
