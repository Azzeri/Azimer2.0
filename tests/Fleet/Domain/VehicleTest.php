<?php

namespace App\Tests\Fleet\Domain;

use App\Fleet\Application\Command\AddVehicleCommand;
use App\Fleet\Domain\Dto\VehicleInputData;
use App\Fleet\Domain\Policy\AddVehicle\VehicleCanBeAdded;
use App\Fleet\Domain\Vehicle;
use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Tests\SampleProvider\Fleet\FleetSamples;
use Mockery;

it(
    'fails to create vehicle when policy fails',
    /**
     * @throws BusinessRuleViolationException|InvalidDataException
     */
    function () {
        // Arrange
        $policy = Mockery::mock(VehicleCanBeAdded::class);
        $policy->shouldReceive("isSatisfiedBy")
            ->once()
            ->andReturn(BusinessRulesNotificationsCollection::create([BusinessRuleNotification::fromString('fail')]));

        $command = new AddVehicleCommand(new VehicleInputData());

        // Act // Assert
        expect(
            fn() => Vehicle::fromInputData($command, $policy)
        )->toThrow(BusinessRuleViolationException::class);
    }
);

it(
    'creates a vehicle from a valid data',
    /**
     * @throws BusinessRuleViolationException|InvalidDataException
     */
    function () {
        // Arrange
        $policy = Mockery::mock(VehicleCanBeAdded::class);
        $policy->shouldReceive("isSatisfiedBy")
            ->once()
            ->andReturn(BusinessRulesNotificationsCollection::create());

        $command = new AddVehicleCommand(FleetSamples::vehicleValidInputData());

        // Act
        $vehicle = Vehicle::fromInputData($command, $policy);

        // Assert
        expect($vehicle)->toBeInstanceOf(Vehicle::class);
    }
);
