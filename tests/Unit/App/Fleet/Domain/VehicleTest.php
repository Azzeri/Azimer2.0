<?php

namespace Tests\Unit\App\Fleet\Domain;

use App\Fleet\Domain\Dto\VehicleInputData;
use App\Fleet\Domain\Policy\AddVehicle\VehicleCanBeAdded;
use App\Fleet\Domain\Vehicle;
use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use Mockery;
use Tests\SampleProvider\Fleet\FleetSamples;

it(
    'fails to create vehicle when policy fails',
    /**
     * @throws BusinessRuleViolationException|InvalidDataException
     */
    function () {
        // Arrange
        $policy = Mockery::mock(VehicleCanBeAdded::class);
        $policy->shouldReceive("checkBusinessRules")
            ->once()
            ->andReturn(BusinessRulesNotificationsCollection::create([BusinessRuleNotification::fromString('fail')]));

        $command = FleetSamples::vehicleValidInputData();

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
        $policy->shouldReceive("checkBusinessRules")
            ->once()
            ->andReturn(BusinessRulesNotificationsCollection::create());

        $command = FleetSamples::vehicleValidInputData();

        // Act
        $vehicle = Vehicle::fromInputData($command, $policy);

        // Assert
        expect($vehicle)->toBeInstanceOf(Vehicle::class);
    }
);
