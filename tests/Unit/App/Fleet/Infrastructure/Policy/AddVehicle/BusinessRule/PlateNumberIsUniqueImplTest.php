<?php

declare(strict_types=1);

namespace Tests\Unit\App\Fleet\Infrastructure\Policy\AddVehicle\BusinessRule;

use App\Fleet\Domain\Dto\VehicleInputData;
use App\Fleet\Domain\Vehicle;
use App\Fleet\Infrastructure\Policy\AddVehicle\BusinessRule\PlateNumberIsUniqueImpl;
use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use Tests\SampleProvider\Fleet\FleetSamples;
use Ecotone\Modelling\StandardRepository;
use Mockery;

it('fails if input data is missing', function () {
    // Arrange
    $repository = Mockery::mock(StandardRepository::class);
    $rule = new PlateNumberIsUniqueImpl($repository);

    // Act
    $result = $rule->check();

    // Assert
    expect($result)->toBeInstanceOf(BusinessRuleNotification::class)
        ->and($result?->message())->toEqual("Missing data to validate plate number uniqueness");
});

it('fails if plate number is missing', function () {
    // Arrange
    $repository = Mockery::mock(StandardRepository::class);
    $rule = new PlateNumberIsUniqueImpl($repository);

    // Act
    $result = $rule->check(new VehicleInputData());

    // Assert
    expect($result)->toBeInstanceOf(BusinessRuleNotification::class)
        ->and($result?->message())->toEqual("Missing data to validate plate number uniqueness");
});

it(
    'fails if plate number is not unique',
    /**
     * @throws BusinessRuleViolationException|InvalidDataException
     */
    function () {
        // Arrange
        $plateNumber = '1234';

        $repository = Mockery::mock(StandardRepository::class);
        $repository->shouldReceive('findBy')
            ->once()
            ->with(
                Vehicle::class,
                ['plateNumber' => $plateNumber]
            )->andReturn(FleetSamples::vehicleAggregate());

        $rule = new PlateNumberIsUniqueImpl($repository);

        // Act
        $result = $rule->check(new VehicleInputData(plateNumber: $plateNumber));

        // Assert
        expect($result)->toBeInstanceOf(BusinessRuleNotification::class)
            ->and($result?->message())->toEqual("Vehicle's plate number: 1234 already exists");
    }
);

it('succeeds if plate number is unique', function () {
    // Arrange
    $plateNumber = '1234';

    $repository = Mockery::mock(StandardRepository::class);
    $repository->shouldReceive('findBy')
        ->once()
        ->with(
            Vehicle::class,
            ['plateNumber' => $plateNumber]
        )->andReturn(null);

    $rule = new PlateNumberIsUniqueImpl($repository);

    // Act
    $result = $rule->check(new VehicleInputData(plateNumber: $plateNumber));

    // Assert
    expect($result)->toBeNull();
});
