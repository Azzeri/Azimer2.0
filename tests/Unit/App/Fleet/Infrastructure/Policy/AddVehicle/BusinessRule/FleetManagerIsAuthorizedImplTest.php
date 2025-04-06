<?php

declare(strict_types=1);

namespace Tests\Unit\App\Fleet\Infrastructure\Policy\AddVehicle\BusinessRule;

use App\Fleet\Domain\Service\FleetManagerPermissionService;
use App\Fleet\Infrastructure\Policy\AddVehicle\BusinessRule\FleetManagerIsAuthorizedImpl;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use Mockery;
use Tests\SampleProvider\Fleet\FleetSamples;

it(
    'fails when fleet manager is not authorized',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $fleetManager = FleetSamples::fleetManager();

        $permissionService = Mockery::mock(FleetManagerPermissionService::class);
        $permissionService->shouldReceive('canAddVehicleToUnit')
            ->once()
            ->andReturn(false);

        $rule = new FleetManagerIsAuthorizedImpl($permissionService);

        // Act
        $result = $rule->check(FleetSamples::vehicleValidInputData(), $fleetManager);

        // Assert
        expect($result)->toBeInstanceOf(BusinessRuleNotification::class)
            ->and($result?->message())->toEqual("Fleet manager not authorized to manage this unit");
    }
);

it(
    'succeeds when fleet manager is authorized',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $fleetManager = FleetSamples::fleetManager();

        $permissionService = Mockery::mock(FleetManagerPermissionService::class);
        $permissionService->shouldReceive('canAddVehicleToUnit')
            ->once()
            ->andReturn(true);

        $rule = new FleetManagerIsAuthorizedImpl($permissionService);

        // Act
        $result = $rule->check(FleetSamples::vehicleValidInputData(), $fleetManager);

        // Assert
        expect($result)->toBeNull();
    }
);
