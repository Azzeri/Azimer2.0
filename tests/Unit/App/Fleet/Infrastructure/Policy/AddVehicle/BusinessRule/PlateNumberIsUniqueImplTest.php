<?php

declare(strict_types=1);

namespace Tests\Unit\App\Fleet\Infrastructure\Policy\AddVehicle\BusinessRule;

use App\Fleet\Application\Command\AddVehicleCommand;
use App\Fleet\Infrastructure\Policy\AddVehicle\BusinessRule\PlateNumberIsUniqueImpl;
use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\Domain\Repository\StandardRepository;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;
use Mockery;
use Tests\SampleProvider\Fleet\FleetSamples;

it(
    'fails if plate number is not unique',
    /**
     * @throws BusinessRuleViolationException|InvalidDataException
     */
    function () {
        // Arrange
        $plateNumber = '1234';
        $command = new AddVehicleCommand($plateNumber, '', '', '', '');

        $repository = Mockery::mock(StandardRepository::class);
        $repository->shouldReceive('findById')
            ->once()
            ->andReturn(FleetSamples::vehicleAggregate());

        $rule = new PlateNumberIsUniqueImpl($repository);

        // Act
        $result = $rule->check($command, FleetSamples::fleetManager());

        // Assert
        expect($result)->toBeInstanceOf(BusinessRuleNotification::class)
            ->and($result?->message())->toEqual("Vehicle's plate number: 1234 already exists");
    }
);

it(
    'succeeds if plate number is unique',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $plateNumber = '1234';
        $command = new AddVehicleCommand($plateNumber, '', '', '', '');

        $repository = Mockery::mock(StandardRepository::class);
        $repository->shouldReceive('findById')
            ->once()
            ->andThrow(ResourceNotFoundException::class);

        $rule = new PlateNumberIsUniqueImpl($repository);

        // Act
        $result = $rule->check($command, FleetSamples::fleetManager());

        // Assert
        expect($result)->toBeNull();
    }
);
