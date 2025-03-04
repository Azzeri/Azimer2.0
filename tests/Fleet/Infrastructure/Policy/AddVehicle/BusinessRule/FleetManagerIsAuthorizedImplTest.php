<?php

declare(strict_types=1);

namespace App\Tests\Fleet\Infrastructure\Policy\AddVehicle\BusinessRule;

use App\Fleet\Domain\Dto\VehicleInputData;
use App\Fleet\Domain\Enum\FleetPermission;
use App\Fleet\Domain\Factory\AssignedUnitFactory;
use App\Fleet\Domain\Factory\FleetManagerFactory;
use App\Fleet\Domain\ValueObject\AssignedUnit;
use App\Fleet\Domain\ValueObject\AssignedUnitId;
use App\Fleet\Infrastructure\Policy\AddVehicle\BusinessRule\FleetManagerIsAuthorizedImpl;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;
use App\Tests\SampleProvider\Fleet\FleetSamples;
use Mockery;
use Symfony\Component\Uid\Uuid;

it(
    'fails when fleet manager is not authorized',
    /**
     * @throws InvalidDataException|ResourceNotFoundException
     */
    function () {
        // Arrange
        $fleetManagerFactory = Mockery::mock(FleetManagerFactory::class);
        $fleetManagerFactory->shouldReceive('fromAuthenticatedUser')
            ->once()
            ->andReturn(FleetSamples::fleetManager([]));

        $unitUuid = Uuid::v4()->toString();
        $unitId = AssignedUnitId::fromString($unitUuid);
        $unit = AssignedUnit::create($unitId);
        $unitFactory = Mockery::mock(AssignedUnitFactory::class);
        $unitFactory->shouldReceive('createFromIdentifier')
            ->once()
            ->andReturn($unit);

        $rule = new FleetManagerIsAuthorizedImpl($fleetManagerFactory, $unitFactory);

        // Act
        $result = $rule->check(new VehicleInputData(assignedUnitId: $unitUuid));

        // Assert
        expect($result)->toBeInstanceOf(BusinessRuleNotification::class)
            ->and($result?->message())->toEqual("Fleet manager not authorized to manage this unit");
    }
);

it(
    'succeeds when fleet manager is authorized',
    /**
     * @throws InvalidDataException|ResourceNotFoundException
     */
    function () {
        // Arrange
        $fleetManagerFactory = Mockery::mock(FleetManagerFactory::class);
        $fleetManagerFactory->shouldReceive('fromAuthenticatedUser')
            ->once()
            ->andReturn(FleetSamples::fleetManager([FleetPermission::ADD_ALL]));

        $unitUuid = Uuid::v4()->toString();
        $unitId = AssignedUnitId::fromString($unitUuid);
        $unit = AssignedUnit::create($unitId);
        $unitFactory = Mockery::mock(AssignedUnitFactory::class);
        $unitFactory->shouldReceive('createFromIdentifier')
            ->once()
            ->andReturn($unit);

        $rule = new FleetManagerIsAuthorizedImpl($fleetManagerFactory, $unitFactory);

        // Act
        $result = $rule->check(new VehicleInputData(assignedUnitId: $unitUuid));

        // Assert
        expect($result)->toBeNull();
    }
);
